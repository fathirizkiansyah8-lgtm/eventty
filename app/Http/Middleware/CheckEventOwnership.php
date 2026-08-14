<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEventOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Please login first',
            ], 401);
        }

        // Get the event_id from route parameter
        $eventId = $request->route('event_id') ?? $request->route('id');

        if (!$eventId) {
            return response()->json([
                'success' => false,
                'message' => 'Event ID not found in request',
            ], 400);
        }

        // Find the event
        $event = Event::find($eventId);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found',
            ], 404);
        }

        // Check if the authenticated user is the owner of the event
        if ($event->organizer_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: You are not the owner of this event',
            ], 403);
        }

        return $next($request);
    }
}
