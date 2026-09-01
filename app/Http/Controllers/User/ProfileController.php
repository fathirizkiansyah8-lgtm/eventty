<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Show profile page
     */
    public function index(): View
    {
        return view('user.profile');
    }

    /**
     * Get user profile data (API)
     */
    public function getProfile(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'nis' => $user->nis,
            'class' => $user->class,
            'phone' => $user->phone,
            'address' => $user->address,
            'avatar_url' => $user->avatar_url,
            'status' => $user->status,
            'created_at' => $user->created_at->format('d F Y'),
            'statistics' => [
                'events_joined' => $user->registeredEvents()->count(),
                'certificates_earned' => $user->certificates()->issued()->count(),
                'attendance_rate' => $this->calculateAttendanceRate($user),
            ]
        ]);
    }

    /**
     * Update profile information
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }

    /**
     * Upload avatar
     */
    public function uploadAvatar(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'avatar.required' => 'File avatar harus dipilih.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'avatar.max' => 'Ukuran file maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();

            // Upload new avatar
            $avatarPath = $this->fileUploadService->uploadUserAvatar(
                $request->file('avatar'),
                $user->avatar_path
            );

            // Update user avatar path
            $user->update(['avatar_path' => $avatarPath]);

            return response()->json([
                'success' => true,
                'message' => 'Avatar berhasil diperbarui.',
                'avatar_url' => $user->avatar_url
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload avatar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete avatar
     */
    public function deleteAvatar(): JsonResponse
    {
        try {
            $user = Auth::user();

            if ($user->avatar_path) {
                // Delete file from storage
                $this->fileUploadService->deleteFile($user->avatar_path);

                // Remove avatar path from user
                $user->update(['avatar_path' => null]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Avatar berhasil dihapus.',
                'avatar_url' => $user->avatar_url
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus avatar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini harus diisi.',
            'password.required' => 'Password baru harus diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini tidak benar.'
            ], 422);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.'
        ]);
    }

    /**
     * Calculate attendance rate
     */
    private function calculateAttendanceRate(User $user): int
    {
        $totalEvents = $user->registeredEvents()->count();

        if ($totalEvents === 0) {
            return 0;
        }

        $attendedEvents = $user->registeredEvents()
            ->wherePivot('attendance_status', 'present')
            ->count();

        return round(($attendedEvents / $totalEvents) * 100);
    }
}
