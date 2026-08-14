<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function stats(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $query = Event::class;
            if ($user->role !== 'super_admin') {
                $query = Event::where('organizer_id', $user->id);
            }

            $totalEvents = Event::count();
            $totalParticipants = Registration::count();
            $totalUsers = User::count();
            $upcomingEvents = Event::where('status', 'published')
                ->where('start_date', '>', now())
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_events' => $totalEvents,
                    'total_participants' => $totalParticipants,
                    'total_users' => $totalUsers,
                    'upcoming_events' => $upcomingEvents,
                    'completed_events' => Event::where('status', 'completed')->count(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get events overview
     */
    public function eventsOverview(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $query = Event::query();
            if ($user->role !== 'super_admin') {
                $query = $query->where('organizer_id', $user->id);
            }

            $events = $query->select('id', 'title', 'start_date', 'capacity', 'current_participants_count', 'status')
                ->with('organizer:id,name')
                ->latest()
                ->limit(10)
                ->get();

            $overview = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'organizer' => $event->organizer->name,
                    'start_date' => $event->start_date,
                    'capacity' => $event->capacity,
                    'registered' => $event->current_participants_count,
                    'remaining' => $event->capacity - $event->current_participants_count,
                    'occupancy_rate' => round(($event->current_participants_count / $event->capacity) * 100, 2) . '%',
                    'status' => $event->status,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $overview,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch events overview',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get attendance rate by event
     */
    public function attendanceRate(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $query = Event::query();
            if ($user->role !== 'super_admin') {
                $query = $query->where('organizer_id', $user->id);
            }

            $events = $query->where('status', 'completed')
                ->with('attendances')
                ->limit(10)
                ->get();

            $data = $events->map(function ($event) {
                $totalRegistered = $event->current_participants_count;
                $totalAttended = $event->attendances()
                    ->where('status', 'present')
                    ->count();

                return [
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'total_registered' => $totalRegistered,
                    'total_attended' => $totalAttended,
                    'attendance_rate' => $totalRegistered > 0 ? 
                        round(($totalAttended / $totalRegistered) * 100, 2) . '%' : '0%',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch attendance rate',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get distribution by category
     */
    public function categoriesDistribution(Request $request)
    {
        try {
            $categories = Event::select('category')
                ->selectRaw('COUNT(*) as count')
                ->selectRaw('SUM(current_participants_count) as total_participants')
                ->groupBy('category')
                ->get();

            $data = $categories->map(function ($category) {
                return [
                    'category' => $category->category,
                    'events' => $category->count,
                    'total_participants' => $category->total_participants,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories distribution',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get monthly events statistics
     */
    public function monthlyStats(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $query = Event::query();
            if ($user->role !== 'super_admin') {
                $query = $query->where('organizer_id', $user->id);
            }

            $stats = $query->selectRaw('MONTH(start_date) as month')
                ->selectRaw('YEAR(start_date) as year')
                ->selectRaw('COUNT(*) as count')
                ->selectRaw('SUM(current_participants_count) as participants')
                ->groupByRaw('MONTH(start_date), YEAR(start_date)')
                ->orderByRaw('YEAR(start_date) DESC, MONTH(start_date) DESC')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $stats,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch monthly stats',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get top events by participants
     */
    public function topEvents(Request $request)
    {
        try {
            $limit = $request->get('limit', 5);

            $events = Event::orderBy('current_participants_count', 'desc')
                ->limit($limit)
                ->select('id', 'title', 'current_participants_count', 'capacity', 'start_date', 'organizer_id')
                ->with('organizer:id,name')
                ->get();

            $data = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'organizer' => $event->organizer->name,
                    'participants' => $event->current_participants_count,
                    'capacity' => $event->capacity,
                    'occupancy' => round(($event->current_participants_count / $event->capacity) * 100, 2) . '%',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch top events',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
