<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Registration;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Get all registrations for authenticated user
     */
    public function index(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $registrations = $user->registrations()
                ->with('event:id,title,start_date,location')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $registrations->items(),
                'pagination' => [
                    'total' => $registrations->total(),
                    'per_page' => $registrations->perPage(),
                    'current_page' => $registrations->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch registrations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get single registration
     */
    public function show(Registration $registration)
    {
        try {
            $user = auth('sanctum')->user();

            if ($registration->user_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $registration->load('user', 'event');

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $registration->id,
                    'registration_number' => $registration->registration_number,
                    'user' => $registration->user,
                    'event' => $registration->event,
                    'registration_date' => $registration->registration_date,
                    'payment_status' => $registration->payment_status,
                    'status' => $registration->status,
                    'created_at' => $registration->created_at,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration not found',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Register user to event
     */
    public function registerEvent(Request $request, Event $event)
    {
        try {
            $user = auth('sanctum')->user();

            // Check if event is published
            if ($event->status !== 'published') {
                return response()->json([
                    'success' => false,
                    'message' => 'Event is not available for registration',
                ], 400);
            }

            // Check if already registered
            $existing = Registration::where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already registered for this event',
                ], 400);
            }

            // Check capacity
            if ($event->current_participants_count >= $event->capacity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event is full, no more spots available',
                ], 400);
            }

            // Create registration
            $registration = Registration::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'registration_date' => now(),
                'registration_number' => 'REG-' . date('YmdHi') . '-' . Str::random(6),
                'payment_status' => $event->is_paid ? 'pending' : 'completed',
                'status' => 'confirmed',
            ]);

            // Create attendance record with QR code
            $qrToken = Str::random(32);
            Attendance::create([
                'registration_id' => $registration->id,
                'event_id' => $event->id,
                'user_id' => $user->id,
                'qr_code_token' => $qrToken,
                'status' => 'pending',
            ]);

            // Update event participant count
            $event->increment('current_participants_count');

            return response()->json([
                'success' => true,
                'message' => 'Successfully registered for event',
                'data' => [
                    'id' => $registration->id,
                    'registration_number' => $registration->registration_number,
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'status' => $registration->status,
                    'qr_token' => $qrToken,
                    'registration_date' => $registration->registration_date,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store registration (admin)
     */
    public function store(StoreRegistrationRequest $request)
    {
        try {
            $event = Event::findOrFail($request->event_id);

            // Check capacity
            if ($event->current_participants_count >= $event->capacity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event is full',
                ], 400);
            }

            $registration = Registration::create([
                'user_id' => auth('sanctum')->user()->id,
                'event_id' => $event->id,
                'registration_date' => now(),
                'registration_number' => 'REG-' . date('YmdHi') . '-' . Str::random(6),
                'status' => 'confirmed',
            ]);

            $event->increment('current_participants_count');

            return response()->json([
                'success' => true,
                'message' => 'Registered successfully',
                'data' => $registration,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cancel registration
     */
    public function destroy(Registration $registration)
    {
        try {
            $user = auth('sanctum')->user();

            if ($registration->user_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $event = $registration->event;
            $registration->delete();

            // Update event participant count
            if ($event->current_participants_count > 0) {
                $event->decrement('current_participants_count');
            }

            return response()->json([
                'success' => true,
                'message' => 'Registration cancelled',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cancellation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get user's registrations
     */
    public function myRegistrations(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $registrations = $user->registrations()
                ->with('event:id,title,start_date,end_date,location')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $registrations->items(),
                'pagination' => [
                    'total' => $registrations->total(),
                    'per_page' => $registrations->perPage(),
                    'current_page' => $registrations->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch registrations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check registration status
     */
    public function checkStatus(Registration $registration)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $registration->id,
                    'registration_number' => $registration->registration_number,
                    'event_id' => $registration->event_id,
                    'status' => $registration->status,
                    'payment_status' => $registration->payment_status,
                    'registration_date' => $registration->registration_date,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get event participants (admin)
     */
    public function eventParticipants(Event $event)
    {
        try {
            $participants = $event->registrations()
                ->with('user:id,name,email,phone')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $participants->items(),
                'pagination' => [
                    'total' => $participants->total(),
                    'per_page' => $participants->perPage(),
                    'current_page' => $participants->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch participants',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add participant manually (admin)
     */
    public function addParticipant(Request $request, Event $event)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $user = \App\Models\User::findOrFail($request->user_id);

            // Check if already registered
            $existing = Registration::where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is already registered for this event',
                ], 400);
            }

            $registration = Registration::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'registration_date' => now(),
                'registration_number' => 'REG-' . date('YmdHi') . '-' . Str::random(6),
                'status' => 'confirmed',
            ]);

            $event->increment('current_participants_count');

            return response()->json([
                'success' => true,
                'message' => 'Participant added successfully',
                'data' => $registration,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add participant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove participant (admin)
     */
    public function removeParticipant(Event $event, \App\Models\User $user)
    {
        try {
            $registration = Registration::where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->firstOrFail();

            $registration->delete();
            $event->decrement('current_participants_count');

            return response()->json([
                'success' => true,
                'message' => 'Participant removed',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove participant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export participants (admin)
     */
    public function exportParticipants(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required|exists:events,id',
            ]);

            $event = Event::findOrFail($request->event_id);
            $participants = $event->registrations()->with('user')->get();

            return response()->json([
                'success' => true,
                'message' => 'Export ready',
                'data' => $participants->map(function ($reg) {
                    return [
                        'registration_number' => $reg->registration_number,
                        'name' => $reg->user->name,
                        'email' => $reg->user->email,
                        'phone' => $reg->user->phone,
                        'registration_date' => $reg->registration_date,
                        'status' => $reg->status,
                    ];
                }),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
