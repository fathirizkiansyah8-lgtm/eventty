<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Get all events (public)
     */
    public function index(Request $request)
    {
        try {
            $query = Event::where('status', 'published')
                ->with('organizer:id,name,email')
                ->select('id', 'title', 'description', 'category', 'location', 'start_date', 
                         'end_date', 'start_time', 'end_time', 'capacity', 'current_participants_count',
                         'organizer_id', 'thumbnail_image_path', 'is_paid', 'price', 'created_at');

            // Pagination
            $perPage = $request->get('per_page', 10);
            $events = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $events->items(),
                'pagination' => [
                    'total' => $events->total(),
                    'per_page' => $events->perPage(),
                    'current_page' => $events->currentPage(),
                    'last_page' => $events->lastPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch events',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get event by ID
     */
    public function show(Event $event)
    {
        try {
            if ($event->status !== 'published' && auth('sanctum')->guest()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event not found',
                ], 404);
            }

            $event->load('organizer:id,name,email', 'registrations');

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'category' => $event->category,
                    'location' => $event->location,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'capacity' => $event->capacity,
                    'current_participants' => $event->current_participants_count,
                    'remaining_spots' => $event->capacity - $event->current_participants_count,
                    'organizer' => $event->organizer,
                    'status' => $event->status,
                    'is_paid' => $event->is_paid,
                    'price' => $event->price,
                    'thumbnail_image_path' => $event->thumbnail_image_path,
                    'is_registered' => auth('sanctum')->check() ? 
                        auth('sanctum')->user()->registrations()->where('event_id', $event->id)->exists() : false,
                    'created_at' => $event->created_at,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch event',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search events
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q');

            if (!$query || strlen($query) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query must be at least 2 characters',
                ], 400);
            }

            $events = Event::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('category', 'like', "%{$query}%");
                })
                ->with('organizer:id,name,email')
                ->select('id', 'title', 'description', 'category', 'location', 'start_date', 
                         'end_date', 'start_time', 'end_time', 'capacity', 'current_participants_count',
                         'organizer_id', 'thumbnail_image_path', 'is_paid', 'price')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $events->items(),
                'pagination' => [
                    'total' => $events->total(),
                    'per_page' => $events->perPage(),
                    'current_page' => $events->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Filter events
     */
    public function filter(Request $request)
    {
        try {
            $query = Event::where('status', 'published');

            // Filter by category
            if ($request->has('category') && $request->category) {
                $query->where('category', $request->category);
            }

            // Filter by date range
            if ($request->has('start_date') && $request->start_date) {
                $query->whereDate('start_date', '>=', $request->start_date);
            }
            if ($request->has('end_date') && $request->end_date) {
                $query->whereDate('end_date', '<=', $request->end_date);
            }

            // Filter by location
            if ($request->has('location') && $request->location) {
                $query->where('location', 'like', "%{$request->location}%");
            }

            // Filter paid/free
            if ($request->has('is_paid')) {
                $query->where('is_paid', $request->is_paid);
            }

            $events = $query->with('organizer:id,name,email')
                ->select('id', 'title', 'description', 'category', 'location', 'start_date', 
                         'end_date', 'start_time', 'end_time', 'capacity', 'current_participants_count',
                         'organizer_id', 'thumbnail_image_path', 'is_paid', 'price')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $events->items(),
                'pagination' => [
                    'total' => $events->total(),
                    'per_page' => $events->perPage(),
                    'current_page' => $events->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Filter failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create event (authenticated users)
     */
    public function store(StoreEventRequest $request)
    {
        try {
            $user = auth('sanctum')->user();

            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'location' => $request->location,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'capacity' => $request->capacity,
                'organizer_id' => $user->id,
                'status' => $request->status ?? 'draft',
                'is_paid' => $request->is_paid ?? false,
                'price' => $request->price ?? 0,
                'thumbnail_image_path' => $request->thumbnail_image_path ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'data' => $event,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create event',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update event
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        try {
            $user = auth('sanctum')->user();

            if ($event->organizer_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update this event',
                ], 403);
            }

            $event->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Event updated successfully',
                'data' => $event,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update event',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete event
     */
    public function destroy(Event $event)
    {
        try {
            $user = auth('sanctum')->user();

            if ($event->organizer_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to delete this event',
                ], 403);
            }

            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Event deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete event',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get user's own events
     */
    public function myEvents(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $events = $user->registeredEvents()
                ->with('organizer:id,name,email')
                ->select('events.id', 'events.title', 'events.description', 'events.category', 
                         'events.location', 'events.start_date', 'events.end_date', 'events.start_time',
                         'events.end_time', 'events.capacity', 'events.current_participants_count',
                         'events.organizer_id', 'events.thumbnail_image_path', 'events.is_paid',
                         'events.price', 'events.created_at')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $events->items(),
                'pagination' => [
                    'total' => $events->total(),
                    'per_page' => $events->perPage(),
                    'current_page' => $events->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch your events',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all events for admin
     */
    public function adminIndex(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            if ($user->role === 'super_admin') {
                $query = Event::with('organizer:id,name,email');
            } else {
                $query = Event::where('organizer_id', $user->id)->with('organizer:id,name,email');
            }

            $events = $query->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $events->items(),
                'pagination' => [
                    'total' => $events->total(),
                    'per_page' => $events->perPage(),
                    'current_page' => $events->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch events',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
