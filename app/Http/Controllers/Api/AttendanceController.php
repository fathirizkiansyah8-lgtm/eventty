<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    /**
     * Get QR code for user's event registration
     */
    public function getQRCode(Request $request, Event $event)
    {
        try {
            $user = auth('sanctum')->user();

            $registration = Registration::where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->firstOrFail();

            $attendance = Attendance::where('registration_id', $registration->id)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => [
                    'qr_token' => $attendance->qr_code_token,
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'qr_code_url' => 'qr_code_' . $attendance->qr_code_token,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'QR code not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Scan QR code and check in
     */
    public function scanQR(Request $request)
    {
        try {
            $request->validate([
                'qr_token' => 'required|string',
            ]);

            $attendance = Attendance::where('qr_code_token', $request->qr_token)
                ->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code',
                ], 400);
            }

            // Check if already checked in
            if ($attendance->check_in_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'Already checked in',
                    'data' => [
                        'check_in_time' => $attendance->check_in_time,
                    ],
                ], 400);
            }

            // Check if event is happening
            $event = $attendance->event;
            $now = now();

            if ($now->isBefore($event->start_date) || $now->isAfter($event->end_date)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event is not currently happening',
                ], 400);
            }

            // Mark attendance
            $attendance->check_in_time = now();
            $attendance->status = 'present';
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Check-in successful',
                'data' => [
                    'user_name' => $attendance->user->name,
                    'event_name' => $event->title,
                    'check_in_time' => $attendance->check_in_time,
                    'status' => $attendance->status,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get attendance history for authenticated user
     */
    public function history(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $attendance = $user->attendances()
                ->with('event:id,title,start_date')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $attendance->items(),
                'pagination' => [
                    'total' => $attendance->total(),
                    'per_page' => $attendance->perPage(),
                    'current_page' => $attendance->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch attendance history',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate QR codes for event participants (admin)
     */
    public function generateQRCodes(Request $request, Event $event)
    {
        try {
            $registrations = $event->registrations()->get();

            foreach ($registrations as $registration) {
                $attendance = Attendance::where('registration_id', $registration->id)
                    ->first();

                if (!$attendance) {
                    Attendance::create([
                        'registration_id' => $registration->id,
                        'event_id' => $event->id,
                        'user_id' => $registration->user_id,
                        'qr_code_token' => Str::random(32),
                        'status' => 'pending',
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'QR codes generated successfully',
                'data' => [
                    'event_id' => $event->id,
                    'total_qr_codes' => Attendance::where('event_id', $event->id)->count(),
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'QR code generation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get QR code list for event (admin)
     */
    public function qrCodeList(Request $request, Event $event)
    {
        try {
            $qrCodes = Attendance::where('event_id', $event->id)
                ->with('user:id,name,email')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $qrCodes->items(),
                'pagination' => [
                    'total' => $qrCodes->total(),
                    'per_page' => $qrCodes->perPage(),
                    'current_page' => $qrCodes->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch QR codes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate QR code (admin)
     */
    public function validateQR(Request $request, $token)
    {
        try {
            $attendance = Attendance::where('qr_code_token', $token)
                ->with('user', 'event', 'registration')
                ->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR code not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'user_name' => $attendance->user->name,
                    'event_name' => $attendance->event->title,
                    'registration_number' => $attendance->registration->registration_number,
                    'check_in_time' => $attendance->check_in_time,
                    'status' => $attendance->status,
                    'is_checked_in' => (bool) $attendance->check_in_time,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get attendance report (admin)
     */
    public function attendanceReport(Request $request, Event $event)
    {
        try {
            $total = Attendance::where('event_id', $event->id)->count();
            $present = Attendance::where('event_id', $event->id)
                ->where('status', 'present')
                ->count();
            $absent = Attendance::where('event_id', $event->id)
                ->where('status', 'absent')
                ->count();
            $pending = Attendance::where('event_id', $event->id)
                ->where('status', 'pending')
                ->count();

            $attendanceRate = $total > 0 ? round(($present / $total) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'total_registered' => $event->current_participants_count,
                    'total_checked_in' => $present,
                    'attendance_rate' => $attendanceRate . '%',
                    'statistics' => [
                        'present' => $present,
                        'absent' => $absent,
                        'pending' => $pending,
                    ],
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mark participant as present (admin)
     */
    public function markPresent(Request $request)
    {
        try {
            $request->validate([
                'qr_token' => 'required|string',
            ]);

            $attendance = Attendance::where('qr_code_token', $request->qr_token)
                ->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR code not found',
                ], 404);
            }

            $attendance->check_in_time = now();
            $attendance->status = 'present';
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Marked as present',
                'data' => [
                    'user_name' => $attendance->user->name,
                    'check_in_time' => $attendance->check_in_time,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as present',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update attendance (admin)
     */
    public function updateAttendance(Request $request, Attendance $attendance)
    {
        try {
            $request->validate([
                'status' => 'required|in:present,absent,pending',
                'check_in_time' => 'nullable|datetime',
                'check_out_time' => 'nullable|datetime',
            ]);

            $attendance->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Attendance updated',
                'data' => $attendance,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export attendance (admin)
     */
    public function exportAttendance(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required|exists:events,id',
            ]);

            $event = Event::findOrFail($request->event_id);
            $attendance = $event->attendances()->with('user')->get();

            $data = $attendance->map(function ($att) {
                return [
                    'user_name' => $att->user->name,
                    'email' => $att->user->email,
                    'phone' => $att->user->phone,
                    'check_in_time' => $att->check_in_time,
                    'check_out_time' => $att->check_out_time,
                    'status' => $att->status,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Export ready',
                'data' => $data,
                'total' => $data->count(),
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
