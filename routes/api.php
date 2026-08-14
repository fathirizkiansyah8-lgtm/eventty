<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\DashboardController;

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Smart Event Management API is running',
        'version' => '1.0.0',
        'timestamp' => now(),
    ]);
});

// Public Authentication Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// Public Event Routes
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event}', [EventController::class, 'show'])->name('show');
    Route::get('/search', [EventController::class, 'search'])->name('search');
    Route::get('/filter', [EventController::class, 'filter'])->name('filter');
});

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth Routes
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    });

    // User Profile Routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('update-profile');
        Route::get('/my-events', [EventController::class, 'myEvents'])->name('my-events');
    });

    // Event Routes
    Route::prefix('events')->name('events.')->group(function () {
        Route::post('/', [EventController::class, 'store'])->name('store')->middleware('can:create-event');
        Route::put('/{event}', [EventController::class, 'update'])->name('update')->middleware('can:update,event');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy')->middleware('can:delete,event');
    });

    // Registration Routes
    Route::prefix('registrations')->name('registrations.')->group(function () {
        Route::get('/', [RegistrationController::class, 'index'])->name('index');
        Route::post('/', [RegistrationController::class, 'store'])->name('store');
        Route::get('/{registration}', [RegistrationController::class, 'show'])->name('show');
        Route::delete('/{registration}', [RegistrationController::class, 'destroy'])->name('destroy');
    });

    Route::post('/events/{event}/register', [RegistrationController::class, 'registerEvent'])->name('register-event');
    Route::get('/registrations/my-registrations', [RegistrationController::class, 'myRegistrations'])->name('my-registrations');
    Route::get('/registrations/{registration}/status', [RegistrationController::class, 'checkStatus'])->name('check-status');

    // Attendance & QR Routes
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/history', [AttendanceController::class, 'history'])->name('history');
        Route::post('/scan-qr', [AttendanceController::class, 'scanQR'])->name('scan-qr');
    });

    Route::get('/events/{event}/qr-code', [AttendanceController::class, 'getQRCode'])->name('get-qr-code');

    // Certificate Routes
    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::get('/', [CertificateController::class, 'index'])->name('index');
        Route::get('/{certificate}', [CertificateController::class, 'show'])->name('show');
        Route::get('/{certificate}/download', [CertificateController::class, 'download'])->name('download');
    });

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::put('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    });
});

// Admin Routes (Require Admin Role)
Route::middleware(['auth:sanctum', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Event Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'adminIndex'])->name('index');
        Route::get('/{event}/participants', [RegistrationController::class, 'eventParticipants'])->name('participants');
        Route::post('/{event}/participants', [RegistrationController::class, 'addParticipant'])->name('add-participant');
        Route::delete('/{event}/participants/{user}', [RegistrationController::class, 'removeParticipant'])->name('remove-participant');
        Route::get('/participants/export', [RegistrationController::class, 'exportParticipants'])->name('export-participants');
    });

    // Admin Attendance Management
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/events/{event}/report', [AttendanceController::class, 'attendanceReport'])->name('report');
        Route::post('/mark-present', [AttendanceController::class, 'markPresent'])->name('mark-present');
        Route::put('/{attendance}', [AttendanceController::class, 'updateAttendance'])->name('update');
        Route::get('/export', [AttendanceController::class, 'exportAttendance'])->name('export');
    });

    // Admin QR Management
    Route::prefix('qr')->name('qr.')->group(function () {
        Route::post('/events/{event}/generate', [AttendanceController::class, 'generateQRCodes'])->name('generate');
        Route::get('/events/{event}/list', [AttendanceController::class, 'qrCodeList'])->name('list');
        Route::get('/{token}/validate', [AttendanceController::class, 'validateQR'])->name('validate');
    });

    // Admin Certificate Management
    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::post('/events/{event}/upload-template', [CertificateController::class, 'uploadTemplate'])->name('upload-template');
        Route::get('/events/{event}/list', [CertificateController::class, 'eventCertificates'])->name('list');
        Route::post('/events/{event}/generate', [CertificateController::class, 'generate'])->name('generate');
        Route::get('/{certificate}/preview', [CertificateController::class, 'preview'])->name('preview');
        Route::get('/export', [CertificateController::class, 'export'])->name('export');
    });

    // Admin Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/stats', [DashboardController::class, 'stats'])->name('stats');
        Route::get('/events-overview', [DashboardController::class, 'eventsOverview'])->name('events-overview');
        Route::get('/attendance-rate', [DashboardController::class, 'attendanceRate'])->name('attendance-rate');
        Route::get('/categories-distribution', [DashboardController::class, 'categoriesDistribution'])->name('categories-distribution');
    });
});

// Catch-all route for undefined endpoints
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint not found',
    ], 404);
});
