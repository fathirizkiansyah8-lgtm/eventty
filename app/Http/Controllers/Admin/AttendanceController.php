<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Show attendance page
     */
    public function index(Request $request): View
    {
        $events = Event::orderBy('date', 'desc')->get(['id', 'name', 'date', 'status']);

        $query = EventParticipant::with(['user', 'event', 'event.category']);

        // Filter by event
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Filter by attendance status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('attendance_status', $request->status);
        }

        // Search by student name / NIS / class
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('class', 'like', "%{$search}%");
            });
        }

        $participants = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        // Summary counts for selected event or overall
        $summaryQuery = EventParticipant::query();
        if ($request->filled('event_id')) {
            $summaryQuery->where('event_id', $request->event_id);
        }
        $summary = [
            'total'     => (clone $summaryQuery)->count(),
            'present'   => (clone $summaryQuery)->where('attendance_status', 'present')->count(),
            'absent'    => (clone $summaryQuery)->where('attendance_status', 'absent')->count(),
            'unchecked' => (clone $summaryQuery)->where('attendance_status', 'registered')->count(),
        ];

        return view('admin.attendance', compact('events', 'participants', 'summary'));
    }

    /**
     * Get attendance list (API)
     */
    public function getAttendance(Request $request): JsonResponse
    {
        $query = EventParticipant::with(['user', 'event', 'event.category']);

        // Filter by event
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('attendance_status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('class', 'like', "%{$search}%");
            });
        }

        $attendances = $query->paginate(20)->through(function ($item) {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'student_name' => $item->user->name,
                'student_nis' => $item->user->nis,
                'student_class' => $item->user->class,
                'student_avatar' => $item->user->avatar_url,
                'event_id' => $item->event_id,
                'event_name' => $item->event->name,
                'event_date' => $item->event->formatted_date,
                'event_category' => $item->event->category->name,
                'registration_date' => $item->registration_date->format('d M Y'),
                'attendance_status' => $item->attendance_status,
                'attendance_checked_at' => $item->attendance_checked_at?->format('d M Y H:i'),
            ];
        });

        return response()->json($attendances);
    }

    /**
     * Mark attendance (API)
     */
    public function mark(Request $request): JsonResponse
    {
        $request->validate([
            'participant_id' => 'required|exists:event_participants,id',
            'status' => 'required|in:present,absent',
        ]);

        $participant = EventParticipant::with(['user', 'event'])->findOrFail($request->participant_id);
        $admin = Auth::user();

        if ($request->status === 'present') {
            $participant->markPresent($admin);
        } else {
            $participant->markAbsent($admin);
        }

        // Send notification to student
        $statusLabel = $request->status === 'present' ? 'hadir' : 'tidak hadir';
        Notification::createForUser($participant->user, [
            'title' => 'Status Kehadiran Diperbarui',
            'message' => "Kehadiran Anda di event '{$participant->event->name}' telah ditandai sebagai {$statusLabel}.",
            'type' => $request->status === 'present' ? 'success' : 'warning',
            'icon' => $request->status === 'present' ? 'fas fa-check-circle' : 'fas fa-times-circle',
            'action_url' => '/user/my-events',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Peserta ditandai sebagai {$statusLabel}.",
            'attendance_status' => $request->status,
        ]);
    }

    /**
     * Mark attendance bulk (API)
     */
    public function markBulk(Request $request): JsonResponse
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'status' => 'required|in:present,absent',
            'participant_ids' => 'required|array',
            'participant_ids.*' => 'exists:event_participants,id',
        ]);

        $admin = Auth::user();
        $count = 0;

        foreach ($request->participant_ids as $participantId) {
            $participant = EventParticipant::find($participantId);
            if ($participant) {
                if ($request->status === 'present') {
                    $participant->markPresent($admin);
                } else {
                    $participant->markAbsent($admin);
                }
                $count++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$count} peserta berhasil ditandai.",
        ]);
    }

    /**
     * Get events list for filter dropdown (API)
     */
    public function getEvents(): JsonResponse
    {
        $events = Event::orderBy('date', 'desc')->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->formatted_date,
                'status' => $event->status,
            ];
        });

        return response()->json($events);
    }
}
