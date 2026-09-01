<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index(): View
    {
        // Get dashboard statistics
        $stats = [
            'total_events' => Event::count(),
            'active_events' => Event::active()->count(),
            'total_participants' => EventParticipant::distinct('user_id')->count(),
            'completed_events' => Event::where('status', 'completed')->count(),
        ];

        // Get recent events
        $recentEvents = Event::with(['category', 'creator'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        return view('admin.dashboard', compact('stats', 'recentEvents'));
    }

    /**
     * Get dashboard statistics (API)
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_events' => Event::count(),
            'active_events' => Event::active()->count(),
            'total_participants' => EventParticipant::distinct('user_id')->count(),
            'completed_events' => Event::where('status', 'completed')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get participation analytics (API)
     */
    public function getParticipationAnalytics(): JsonResponse
    {
        // Get participation data by month for the last 6 months
        $participationData = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');
            $months[] = $monthName;

            $count = EventParticipant::whereYear('created_at', $date->year)
                                   ->whereMonth('created_at', $date->month)
                                   ->count();
            $participationData[] = $count;
        }

        return response()->json([
            'labels' => $months,
            'data' => $participationData,
        ]);
    }

    /**
     * Get attendance analytics (API)
     */
    public function getAttendanceAnalytics(): JsonResponse
    {
        $attendanceStats = EventParticipant::select('attendance_status', DB::raw('count(*) as total'))
                                          ->groupBy('attendance_status')
                                          ->get()
                                          ->mapWithKeys(function ($item) {
                                              return [$item->attendance_status => $item->total];
                                          });

        // Ensure all statuses are present
        $allStatuses = ['present', 'absent', 'registered', 'cancelled'];
        foreach ($allStatuses as $status) {
            if (!isset($attendanceStats[$status])) {
                $attendanceStats[$status] = 0;
            }
        }

        return response()->json([
            'labels' => ['Hadir', 'Tidak Hadir', 'Terdaftar', 'Dibatalkan'],
            'data' => [
                $attendanceStats['present'],
                $attendanceStats['absent'],
                $attendanceStats['registered'],
                $attendanceStats['cancelled']
            ],
            'colors' => ['#10b981', '#ef4444', '#3b82f6', '#6b7280']
        ]);
    }

    /**
     * Get recent events (API)
     */
    public function getRecentEvents(): JsonResponse
    {
        $recentEvents = Event::with(['category', 'creator'])
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get()
                            ->map(function ($event) {
                                return [
                                    'id' => $event->id,
                                    'name' => $event->name,
                                    'date' => $event->formatted_date,
                                    'time' => $event->formatted_time,
                                    'category' => $event->category->name,
                                    'category_color' => $event->category->color,
                                    'registered_count' => $event->registered_count,
                                    'quota' => $event->quota,
                                    'status' => $event->status,
                                    'created_by' => $event->creator->name,
                                    'created_at' => $event->created_at->format('d M Y'),
                                ];
                            });

        return response()->json($recentEvents);
    }

    /**
     * Get events overview (API)
     */
    public function getEventsOverview(): JsonResponse
    {
        $overview = [
            'upcoming' => Event::upcoming()->active()->count(),
            'ongoing' => Event::whereDate('date', Carbon::today())->active()->count(),
            'completed' => Event::where('date', '<', Carbon::today())->count(),
            'draft' => Event::where('status', 'draft')->count(),
        ];

        return response()->json($overview);
    }

    /**
     * Get popular events (API)
     */
    public function getPopularEvents(): JsonResponse
    {
        $popularEvents = Event::with(['category'])
                             ->where('registered_count', '>', 0)
                             ->orderBy('registered_count', 'desc')
                             ->limit(5)
                             ->get()
                             ->map(function ($event) {
                                 return [
                                     'id' => $event->id,
                                     'name' => $event->name,
                                     'category' => $event->category->name,
                                     'registered_count' => $event->registered_count,
                                     'quota' => $event->quota,
                                     'percentage' => $event->quota > 0 ? round(($event->registered_count / $event->quota) * 100) : 0,
                                 ];
                             });

        return response()->json($popularEvents);
    }
}
