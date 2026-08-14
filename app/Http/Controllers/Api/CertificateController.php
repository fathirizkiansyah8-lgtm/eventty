<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Attendance;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Get user's certificates
     */
    public function index(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $certificates = $user->certificates()
                ->with('event:id,title,start_date')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $certificates->items(),
                'pagination' => [
                    'total' => $certificates->total(),
                    'per_page' => $certificates->perPage(),
                    'current_page' => $certificates->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch certificates',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get certificate detail
     */
    public function show(Certificate $certificate)
    {
        try {
            $user = auth('sanctum')->user();

            if ($certificate->user_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $certificate->load('user', 'event');

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $certificate->id,
                    'certificate_number' => $certificate->certificate_number,
                    'user' => $certificate->user,
                    'event' => $certificate->event,
                    'issued_date' => $certificate->issued_date,
                    'is_downloaded' => $certificate->is_downloaded,
                    'downloaded_at' => $certificate->downloaded_at,
                    'created_at' => $certificate->created_at,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate not found',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download certificate
     */
    public function download(Certificate $certificate)
    {
        try {
            $user = auth('sanctum')->user();

            if ($certificate->user_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $certificate->update([
                'is_downloaded' => true,
                'downloaded_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificate download link ready',
                'data' => [
                    'certificate_path' => $certificate->certificate_path,
                    'certificate_number' => $certificate->certificate_number,
                    'downloaded_at' => $certificate->downloaded_at,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Download failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload certificate template (admin)
     */
    public function uploadTemplate(Request $request, Event $event)
    {
        try {
            $request->validate([
                'template_file' => 'required|file|mimes:pdf,jpg,jpeg,png',
            ]);

            $user = auth('sanctum')->user();

            if ($event->organizer_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $file = $request->file('template_file');
            $filename = 'template_' . $event->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('certificates/templates', $filename, 'public');

            $event->update([
                'certificate_template_path' => $path,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificate template uploaded successfully',
                'data' => [
                    'event_id' => $event->id,
                    'template_path' => $path,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Template upload failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get event certificates (admin)
     */
    public function eventCertificates(Request $request, Event $event)
    {
        try {
            $certificates = $event->certificates()
                ->with('user:id,name,email')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $certificates->items(),
                'pagination' => [
                    'total' => $certificates->total(),
                    'per_page' => $certificates->perPage(),
                    'current_page' => $certificates->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch certificates',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate certificates for event (admin)
     */
    public function generate(Request $request, Event $event)
    {
        try {
            $user = auth('sanctum')->user();

            if ($event->organizer_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            if (!$event->certificate_template_path) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate template not uploaded',
                ], 400);
            }

            // Get all attendees who were present
            $attendances = Attendance::where('event_id', $event->id)
                ->where('status', 'present')
                ->get();

            $generatedCount = 0;

            foreach ($attendances as $attendance) {
                $existing = Certificate::where('registration_id', $attendance->registration_id)->exists();

                if (!$existing) {
                    $certificatePath = 'certificates/' . $event->id . '/' . 
                                     $attendance->user->id . '_' . 
                                     Str::random(8) . '.pdf';

                    Certificate::create([
                        'registration_id' => $attendance->registration_id,
                        'event_id' => $event->id,
                        'user_id' => $attendance->user_id,
                        'certificate_path' => $certificatePath,
                        'certificate_number' => 'CERT-' . date('Y') . '-' . Str::random(8),
                        'issued_date' => now(),
                    ]);

                    $generatedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Certificates generated successfully',
                'data' => [
                    'event_id' => $event->id,
                    'total_generated' => $generatedCount,
                    'total_attendees' => $attendances->count(),
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate generation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Preview certificate (admin)
     */
    public function preview(Request $request, Certificate $certificate)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $certificate->id,
                    'certificate_number' => $certificate->certificate_number,
                    'user_name' => $certificate->user->name,
                    'event_title' => $certificate->event->title,
                    'issued_date' => $certificate->issued_date,
                    'template_path' => $certificate->event->certificate_template_path,
                    'preview_url' => '/certificates/' . $certificate->id,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Preview failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export certificates (admin)
     */
    public function export(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required|exists:events,id',
            ]);

            $event = Event::findOrFail($request->event_id);
            $certificates = $event->certificates()->with('user')->get();

            $data = $certificates->map(function ($cert) {
                return [
                    'certificate_number' => $cert->certificate_number,
                    'user_name' => $cert->user->name,
                    'email' => $cert->user->email,
                    'issued_date' => $cert->issued_date,
                    'is_downloaded' => $cert->is_downloaded ? 'Yes' : 'No',
                    'downloaded_at' => $cert->downloaded_at,
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
