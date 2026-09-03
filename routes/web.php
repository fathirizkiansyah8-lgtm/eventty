<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\CertificateController as UserCertificateController;
use App\Http\Controllers\User\NotificationController as UserNotificationController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\ParticipantsController as AdminParticipantsController;
use App\Http\Controllers\Admin\StudentsController as AdminStudentsController;
use App\Http\Controllers\Admin\AnnouncementsController as AdminAnnouncementsController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\FileController as AdminFileController;

// Public routes
Route::get('/events/public', function () {
    return view('event-public');
});

Route::get('/', function () {
    return redirect('/landing');
});

Route::get('/landing', function () {
    return view('auth.landing');
})->name('landing');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin redirect
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});

// User Dashboard Routes - Protected by auth and role:student middleware
Route::prefix('user')->middleware(['auth', 'role:student'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Events
    Route::get('/events', [UserEventController::class, 'index'])->name('user.events');
    Route::get('/events/{id}', [UserEventController::class, 'show'])->name('user.event-detail');
    Route::get('/my-events', [UserEventController::class, 'myEvents'])->name('user.my-events');
    Route::post('/events/register', [UserEventController::class, 'register'])->name('user.event-register');
    Route::post('/events/cancel', [UserEventController::class, 'cancelRegistration'])->name('user.event-cancel');

    // Certificates
    Route::get('/certificates', [UserCertificateController::class, 'index'])->name('user.certificates');
    Route::get('/certificates/{id}/download', [UserCertificateController::class, 'download'])->name('user.certificates.download');
    Route::get('/certificates/{id}/view', [UserCertificateController::class, 'view'])->name('user.certificates.view');

    // Notifications
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('user.notifications');
    Route::post('/notifications/{id}/read', [UserNotificationController::class, 'markAsRead'])->name('user.notifications.read');
    Route::post('/notifications/read-all', [UserNotificationController::class, 'markAllAsRead'])->name('user.notifications.read-all');
    Route::delete('/notifications/{id}', [UserNotificationController::class, 'delete'])->name('user.notifications.delete');
    Route::delete('/notifications', [UserNotificationController::class, 'deleteAll'])->name('user.notifications.delete-all');

    // Profile & Settings
    Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile/update', [UserProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/profile/avatar', [UserProfileController::class, 'uploadAvatar'])->name('user.profile.avatar');
    Route::delete('/profile/avatar', [UserProfileController::class, 'deleteAvatar'])->name('user.profile.avatar.delete');
    Route::post('/profile/password', [UserProfileController::class, 'changePassword'])->name('user.profile.password');

    Route::get('/settings', function () {
        return view('user.settings');
    })->name('user.settings');

    Route::get('/messages', function () {
        return view('user.messages');
    })->name('user.messages');
});

// Admin Dashboard Routes - Protected by auth and role:admin middleware
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Events
    Route::resource('/events', AdminEventController::class, ['as' => 'admin']);

    // File Management
    Route::prefix('files')->group(function () {
        Route::post('/upload', [AdminFileController::class, 'uploadTemp'])->name('admin.files.upload');
        Route::delete('/delete', [AdminFileController::class, 'delete'])->name('admin.files.delete');
        Route::get('/info', [AdminFileController::class, 'info'])->name('admin.files.info');
        Route::get('/list', [AdminFileController::class, 'listFiles'])->name('admin.files.list');
    });

    // Other admin pages
    Route::get('/participants', [AdminParticipantsController::class, 'index'])->name('admin.participants');

    Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('admin.attendance');

    Route::get('/certificates', function () {
        return view('admin.certificates');
    })->name('admin.certificates');

    Route::get('/messages', function () {
        return view('admin.messages');
    })->name('admin.messages');

    Route::get('/announcements', [AdminAnnouncementsController::class, 'index'])->name('admin.announcements');
    Route::post('/announcements', [AdminAnnouncementsController::class, 'store'])->name('admin.announcements.store');
    Route::delete('/announcements/{id}', [AdminAnnouncementsController::class, 'destroy'])->name('admin.announcements.destroy');
    Route::patch('/announcements/{id}/toggle', [AdminAnnouncementsController::class, 'toggleStatus'])->name('admin.announcements.toggle');

    Route::get('/students', [AdminStudentsController::class, 'index'])->name('admin.students');

    Route::get('/notifications', function () {
        return view('admin.notifications');
    })->name('admin.notifications');

    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings/profile', [AdminSettingsController::class, 'updateProfile'])->name('admin.settings.profile');
    Route::post('/settings/password', [AdminSettingsController::class, 'changePassword'])->name('admin.settings.password');
});

// API Routes for AJAX calls
Route::prefix('api')->middleware(['auth'])->group(function () {
    // User API routes
    Route::middleware('role:student')->group(function () {
        Route::get('/user/stats', [UserDashboardController::class, 'getStats']);
        Route::get('/user/nearest-event', [UserDashboardController::class, 'getNearestEvent']);
        Route::get('/user/upcoming-events', [UserDashboardController::class, 'getUpcomingEvents']);
        Route::get('/user/notifications-count', [UserDashboardController::class, 'getNotificationsCount']);

        Route::get('/user/events', [UserEventController::class, 'getEvents']);
        Route::get('/user/events/{id}', [UserEventController::class, 'getEvent']);
        Route::get('/user/my-events', [UserEventController::class, 'getMyEvents']);

        Route::get('/user/certificates', [UserCertificateController::class, 'getCertificates']);

        Route::get('/user/notifications', [UserNotificationController::class, 'getNotifications']);
        Route::get('/user/notifications/unread-count', [UserNotificationController::class, 'getUnreadCount']);

        Route::get('/user/profile', [UserProfileController::class, 'getProfile']);
    });

    // Admin API routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/stats', [AdminDashboardController::class, 'getStats']);
        Route::get('/admin/participation-analytics', [AdminDashboardController::class, 'getParticipationAnalytics']);
        Route::get('/admin/attendance-analytics', [AdminDashboardController::class, 'getAttendanceAnalytics']);
        Route::get('/admin/recent-events', [AdminDashboardController::class, 'getRecentEvents']);
        Route::get('/admin/events-overview', [AdminDashboardController::class, 'getEventsOverview']);
        Route::get('/admin/popular-events', [AdminDashboardController::class, 'getPopularEvents']);

        Route::get('/admin/events', [AdminEventController::class, 'getEvents']);
        Route::get('/admin/categories', [AdminEventController::class, 'getCategories']);

        // Attendance API
        Route::get('/admin/attendance', [AdminAttendanceController::class, 'getAttendance']);
        Route::get('/admin/attendance/events', [AdminAttendanceController::class, 'getEvents']);
        Route::post('/admin/attendance/mark', [AdminAttendanceController::class, 'mark']);
        Route::post('/admin/attendance/mark-bulk', [AdminAttendanceController::class, 'markBulk']);

        // Certificate issue
        Route::post('/admin/certificates/issue', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'user_id'  => 'required|exists:users,id',
                'event_id' => 'required|exists:events,id',
            ]);

            $exists = \App\Models\Certificate::where('user_id', $request->user_id)
                ->where('event_id', $request->event_id)->exists();

            if ($exists) {
                return response()->json(['success' => false, 'message' => 'Sertifikat sudah ada.']);
            }

            \App\Models\Certificate::create([
                'user_id'            => $request->user_id,
                'event_id'           => $request->event_id,
                'certificate_type'   => 'participation',
                'issued_date'        => now(),
                'status'             => 'issued',
                'issued_by'          => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Sertifikat berhasil diterbitkan.']);
        });
    });
});
