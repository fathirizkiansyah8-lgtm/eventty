<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventParticipant;
use App\Models\Certificate;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show user dashboard
     */
    public function index(): View
    {
        $user = Auth::user();

        // Get dashboard statistics
        $stats = [
            'events_joined' => $user->registeredEvents()->count(),
            'upcoming_events' => $user->registeredEvents()->upcoming()->count(),
            'completed_events' => $user->registeredEvents()->where('events.date', '<', Carbon::today())->count(),
            'certificates' => $user->certificates()->issued()->count(),
        ];

        // Get nearest upcoming event yang user sudah daftar
        $nearestEvent = $user->registeredEvents()
            ->upcoming()
            ->with(['category'])
            ->orderBy('events.date')
            ->orderBy('events.start_time')
            ->first();

        // Get upcoming events (next 6)
        $upcomingEvents = Event::active()
            ->upcoming()
            ->with(['category'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(6)
            ->get();

        // Categories for filter chips
        $categories = EventCategory::orderBy('name')->get();

        return view('user.dashboard', compact('stats', 'nearestEvent', 'upcomingEvents', 'categories'));
    }

    /**
     * Get dashboard statistics (API)
     */
    public function getStats(): JsonResponse
    {
        $user = Auth::user();

        $stats = [
            'events_joined' => $user->registeredEvents()->count(),
            'upcoming_events' => $user->registeredEvents()->upcoming()->count(),
            'completed_events' => $user->registeredEvents()->where('events.date', '<', Carbon::today())->count(),
            'certificates' => $user->certificates()->issued()->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get nearest event (API)
     */
    public function getNearestEvent(): JsonResponse
    {
        $user = Auth::user();

        $nearestEvent = $user->registeredEvents()
            ->upcoming()
            ->orderBy('events.date')
            ->orderBy('events.start_time')
            ->with(['category'])
            ->first();

        if (!$nearestEvent) {
            return response()->json(null);
        }

        return response()->json([
            'id' => $nearestEvent->id,
            'name' => $nearestEvent->name,
            'date' => $nearestEvent->formatted_date,
            'time' => $nearestEvent->formatted_time,
            'location' => $nearestEvent->location,
            'category' => $nearestEvent->category->name,
            'days_until' => $nearestEvent->days_until_event,
            'banner_url' => $nearestEvent->banner_url,
        ]);
    }

    /**
     * Get upcoming events (API)
     */
    public function getUpcomingEvents(): JsonResponse
    {
        $upcomingEvents = Event::active()
            ->upcoming()
            ->with(['category'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(6)
            ->get()
            ->map(function ($event) {
                return [
                    'id'               => $event->id,
                    'name'             => $event->name,
                    'date'             => $event->formatted_date,
                    'time'             => $event->formatted_time,
                    'location'         => $event->location,
                    'category'         => $event->category->name,
                    'category_color'   => $event->category->color,
                    'quota'            => $event->quota,
                    'registered_count' => $event->registered_count,
                    'remaining_slots'  => $event->getRemainingSlots(),
                    'is_full'          => $event->isFull(),
                    'banner_url'       => $event->banner_url,
                    'has_certificate'  => (bool) $event->has_certificate,
                ];
            });

        return response()->json($upcomingEvents);
    }

    /**
     * Get user notifications count
     */
    public function getNotificationsCount(): JsonResponse
    {
        $user = Auth::user();

        $count = $user->unreadNotificationsCount();

        return response()->json(['count' => $count]);
    }
}
