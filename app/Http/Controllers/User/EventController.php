<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventParticipant;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Show all events page
     */
    public function index(Request $request): View
    {
        $categories = EventCategory::orderBy('name')->get();
        return view('user.events', compact('categories'));
    }

    /**
     * Show event detail page
     */
    public function show($id): View
    {
        $event = Event::with(['category', 'creator'])->findOrFail($id);
        $user = Auth::user();
        $isRegistered = $event->isUserRegistered($user);

        return view('user.event-detail', compact('event', 'isRegistered'));
    }

    /**
     * Show my events page
     */
    public function myEvents(): View
    {
        return view('user.my-events');
    }

    /**
     * Get events list (API)
     */
    public function getEvents(Request $request): JsonResponse
    {
        $query = Event::active()->with(['category']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            switch ($request->status) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'available':
                    $query->where('status', 'open')->where('registered_count', '<', DB::raw('quota'));
                    break;
                case 'full':
                    $query->where('registered_count', '>=', DB::raw('quota'));
                    break;
            }
        }

        // Sorting
        $sort = $request->get('sort', 'date');
        switch ($sort) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'category':
                $query->join('event_categories', 'events.category_id', '=', 'event_categories.id')
                      ->orderBy('event_categories.name');
                break;
            default:
                $query->orderBy('date')->orderBy('start_time');
        }

        $events = $query->paginate(12)->through(function ($event) {
            $user = Auth::user();
            return [
                'id'               => $event->id,
                'name'             => $event->name,
                'description'      => $event->description,
                'date'             => $event->formatted_date,
                'time'             => $event->formatted_time,
                'location'         => $event->location,
                'organizer'        => $event->organizer,
                'category'         => $event->category->name,
                'category_color'   => $event->category->color,
                'quota'            => $event->quota,
                'registered_count' => $event->registered_count,
                'remaining_slots'  => $event->getRemainingSlots(),
                'is_full'          => $event->isFull(),
                'is_registered'    => $event->isUserRegistered($user),
                'status'           => $event->status,
                'banner_url'       => $event->banner_url,
                'days_until'       => $event->days_until_event,
                'has_certificate'  => (bool) $event->has_certificate,
            ];
        });

        return response()->json($events);
    }

    /**
     * Get event detail (API)
     */
    public function getEvent($id): JsonResponse
    {
        $event = Event::with(['category', 'creator'])->findOrFail($id);
        $user = Auth::user();

        return response()->json([
            'id'               => $event->id,
            'name'             => $event->name,
            'description'      => $event->description,
            'date'             => $event->formatted_date,
            'time'             => $event->formatted_time,
            'location'         => $event->location,
            'organizer'        => $event->organizer,
            'category'         => $event->category->name,
            'category_color'   => $event->category->color,
            'quota'            => $event->quota,
            'registered_count' => $event->registered_count,
            'remaining_slots'  => $event->getRemainingSlots(),
            'is_full'          => $event->isFull(),
            'is_registered'    => $event->isUserRegistered($user),
            'status'           => $event->status,
            'banner_url'       => $event->banner_url,
            'days_until'       => $event->days_until_event,
            'created_by'       => $event->creator->name,
            'has_certificate'  => (bool) $event->has_certificate,
        ]);
    }

    /**
     * Register for event
     */
    public function register(Request $request): JsonResponse
    {
        $event = Event::findOrFail($request->event_id);
        $user = Auth::user();

        // Check if already registered
        if ($event->isUserRegistered($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar untuk event ini.'
            ], 400);
        }

        // Check if event is full
        if ($event->isFull()) {
            return response()->json([
                'success' => false,
                'message' => 'Event ini sudah penuh.'
            ], 400);
        }

        // Check if event is still open
        if ($event->status !== 'open') {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran untuk event ini sudah ditutup.'
            ], 400);
        }

        DB::transaction(function () use ($event, $user) {
            // Create registration
            EventParticipant::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'registration_date' => now(),
                'attendance_status' => 'registered',
            ]);

            // Update registered count
            $event->incrementRegisteredCount();

            // Create notification
            Notification::createForUser($user, [
                'title' => 'Pendaftaran Berhasil',
                'message' => "Anda berhasil mendaftar untuk event '{$event->name}'.",
                'type' => 'success',
                'icon' => 'fas fa-check-circle',
                'action_url' => route('user.my-events'),
                'metadata' => ['event_id' => $event->id],
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => "Selamat! Anda berhasil mendaftar untuk '{$event->name}'."
        ]);
    }

    /**
     * Get my registered events
     */
    public function getMyEvents(Request $request): JsonResponse
    {
        $user = Auth::user();
        $query = $user->registeredEvents()->with(['category']);

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->wherePivot('attendance_status', $request->status);
        }

        $events = $query->orderBy('events.date', 'desc')
                       ->get()
                       ->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->formatted_date,
                'time' => $event->formatted_time,
                'location' => $event->location,
                'category' => $event->category->name,
                'category_color' => $event->category->color,
                'attendance_status' => $event->pivot->attendance_status,
                'registration_date' => $event->pivot->registration_date->format('d F Y'),
                'banner_url' => $event->banner_url,
                'is_upcoming' => $event->isUpcoming(),
                'can_get_certificate' => $event->pivot->attendance_status === 'present' && !$event->isUpcoming(),
            ];
        });

        return response()->json($events);
    }

    /**
     * Cancel event registration
     */
    public function cancelRegistration(Request $request): JsonResponse
    {
        $event = Event::findOrFail($request->event_id);
        $user = Auth::user();

        $participant = EventParticipant::where('event_id', $event->id)
                                     ->where('user_id', $user->id)
                                     ->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak terdaftar untuk event ini.'
            ], 400);
        }

        // Check if event has started
        if (!$event->isUpcoming()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membatalkan pendaftaran untuk event yang sudah berlangsung.'
            ], 400);
        }

        DB::transaction(function () use ($event, $participant) {
            // Update status to cancelled
            $participant->update(['attendance_status' => 'cancelled']);

            // Decrease registered count
            $event->decrementRegisteredCount();
        });

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dibatalkan.'
        ]);
    }
}
