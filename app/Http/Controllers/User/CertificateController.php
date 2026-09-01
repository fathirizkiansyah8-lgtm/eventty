<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Show certificates page
     */
    public function index(): View
    {
        return view('user.certificates');
    }

    /**
     * Get user certificates (API)
     */
    public function getCertificates(Request $request): JsonResponse
    {
        $user = Auth::user();
        $query = $user->certificates()->with(['event', 'event.category'])->issued();

        // Type filter
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('certificate_type', $request->type);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('event', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $certificates = $query->orderBy('issued_date', 'desc')
                            ->get()
                            ->map(function ($certificate) {
            return [
                'id' => $certificate->id,
                'certificate_number' => $certificate->certificate_number,
                'certificate_type' => $certificate->formatted_type,
                'event_name' => $certificate->event->name,
                'event_category' => $certificate->event->category->name,
                'event_date' => $certificate->event->formatted_date,
                'issued_date' => $certificate->issued_date->format('d F Y'),
                'certificate_url' => $certificate->certificate_url,
                'status' => $certificate->status,
                'description' => $certificate->description,
            ];
        });

        return response()->json($certificates);
    }

    /**
     * Download certificate
     */
    public function download($id): JsonResponse
    {
        $user = Auth::user();
        $certificate = Certificate::where('user_id', $user->id)
                                ->where('id', $id)
                                ->issued()
                                ->firstOrFail();

        if (!$certificate->certificate_path) {
            return response()->json([
                'success' => false,
                'message' => 'File sertifikat tidak tersedia.'
            ], 404);
        }

        // For now, just return success response
        // In production, implement actual file download
        return response()->json([
            'success' => true,
            'message' => 'Sertifikat berhasil diunduh (fitur download belum diimplementasikan).',
            'download_url' => $certificate->certificate_url,
        ]);
    }

    /**
     * View certificate
     */
    public function view($id): JsonResponse
    {
        $user = Auth::user();
        $certificate = Certificate::where('user_id', $user->id)
                                ->where('id', $id)
                                ->with(['event', 'event.category', 'issuer'])
                                ->firstOrFail();

        return response()->json([
            'id' => $certificate->id,
            'certificate_number' => $certificate->certificate_number,
            'certificate_type' => $certificate->formatted_type,
            'event_name' => $certificate->event->name,
            'event_category' => $certificate->event->category->name,
            'event_date' => $certificate->event->formatted_date,
            'event_location' => $certificate->event->location,
            'issued_date' => $certificate->issued_date->format('d F Y'),
            'issued_by' => $certificate->issuer->name,
            'certificate_url' => $certificate->certificate_url,
            'status' => $certificate->status,
            'description' => $certificate->description,
            'user_name' => $certificate->user->name,
            'user_nis' => $certificate->user->nis,
            'user_class' => $certificate->user->class,
        ]);
    }
}
