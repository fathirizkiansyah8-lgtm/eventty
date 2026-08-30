<?php

use Illuminate\Support\Facades\Route;

Route::get('/events/public', function () {
    return view('event-public');
});

Route::get('/', function () {
    return redirect('/landing');
});

Route::get('/landing', function () {
    return view('auth.landing');
})->name('landing');

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $role = $request->input('role');
    $name = strtolower($request->input('name', ''));
    $nis = strtolower($request->input('nis', ''));

    if ($role === 'admin' || $name === 'admin' || $nis === 'admin') {
        return redirect('/admin/dashboard');
    }
    return redirect('/user/dashboard');
});

Route::post('/logout', function () {
    return redirect('/login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});

Route::get('/reset-password', function () {
    return view('auth.reset-password');
});

// User Dashboard Routes
Route::prefix('user')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    });

    Route::get('/events', function () {
        return view('user.events');
    });

    Route::get('/events/{id}', function ($id) {
        $views = [
            '1' => 'user.event-detail',
            '2' => 'user.event-detail-2',
            '3' => 'user.event-detail-3',
            '4' => 'user.event-detail-4',
            '5' => 'user.event-detail-5',
        ];
        return view($views[$id] ?? 'user.event-detail');
    });

    Route::post('/events/register', function (\Illuminate\Http\Request $request) {
        $eventName = $request->input('event_name', 'Event');
        return redirect('/user/my-events')->with('success', 'Selamat! Anda berhasil mendaftar pada ' . $eventName . '.');
    });

    Route::get('/event-detail/{id}', function ($id) {
        return view('user.event-detail');
    });

    Route::get('/my-events', function () {
        return view('user.my-events');
    });

    Route::get('/certificates', function () {
        return view('user.certificates');
    });

    Route::get('/notifications', function () {
        return view('user.notifications');
    });

    Route::get('/profile', function () {
        return view('user.profile');
    });

    Route::get('/settings', function () {
        return view('user.settings');
    });

    Route::get('/messages', function () {
        return view('user.messages');
    });
});

// Admin Dashboard Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/events', function () {
        return view('admin.events');
    });

    Route::get('/events/create', function () {
        return view('admin.create-event');
    });

    Route::get('/events/edit/{id}', function ($id) {
        return view('admin.edit-event');
    });

    Route::get('/participants', function () {
        return view('admin.participants');
    });

    Route::get('/attendance', function () {
        return view('admin.attendance');
    });

    Route::get('/certificates', function () {
        return view('admin.certificates');
    });

    Route::get('/announcements', function () {
        return view('admin.announcements');
    });

    Route::get('/students', function () {
        return view('admin.students');
    });

    Route::get('/notifications', function () {
        return view('admin.notifications');
    });

    Route::get('/settings', function () {
        return view('admin.settings');
    });

    Route::get('/messages', function () {
        return view('admin.messages');
    });
});