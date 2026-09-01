<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect('/admin/dashboard');
            }
            return redirect('/user/dashboard');
        }
        return view('auth.login');
    }

    /**
     * Show the registration form
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Show the reset password form
     */
    public function showResetPasswordForm(): View
    {
        return view('auth.reset-password');
    }

    /**
     * Handle login request.
     * Form mengirim: name (Nama Lengkap), nis (NIS), password
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required',
        ]);

        $name     = trim($request->input('name', ''));
        $nis      = trim($request->input('nis', ''));
        $password = $request->input('password');

        // Minimal salah satu dari name/nis harus diisi
        if (empty($name) && empty($nis)) {
            return redirect()->back()
                ->withErrors(['name' => 'Nama atau NIS harus diisi.'])
                ->withInput();
        }

        // Cari user: prioritaskan NIS, fallback ke nama
        $user = null;

        if (!empty($nis)) {
            $user = User::where('nis', $nis)->first();
        }

        if (!$user && !empty($name)) {
            $user = User::where('name', $name)->first();
        }

        // User tidak ditemukan
        if (!$user) {
            return redirect()->back()
                ->withErrors(['name' => 'Nama atau NIS tidak terdaftar.'])
                ->withInput();
        }

        // Akun tidak aktif
        if ($user->status !== 'active') {
            return redirect()->back()
                ->withErrors(['name' => 'Akun Anda tidak aktif. Hubungi admin.'])
                ->withInput();
        }

        // Password salah
        if (!Hash::check($password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password yang Anda masukkan salah.'])
                ->withInput();
        }

        // Login berhasil
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->intended('/admin/dashboard')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return redirect()->intended('/user/dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Handle registration request.
     * Form mengirim: name, class, nis, password, password_confirmation
     * Email di-generate otomatis dari NIS jika tidak diisi
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'class'                 => 'required|string|max:50',
            'nis'                   => 'required|string|max:20|unique:users,nis',
            'password'              => 'required|string|min:6|confirmed',
        ], [
            'name.required'         => 'Nama harus diisi.',
            'class.required'        => 'Kelas harus diisi.',
            'nis.required'          => 'NIS harus diisi.',
            'nis.unique'            => 'NIS sudah terdaftar.',
            'password.required'     => 'Password harus diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        // Email di-generate dari NIS agar kolom unique tidak conflict
        $email = $request->input('email')
            ?: strtolower(preg_replace('/\s+/', '.', $request->name)) . '.' . $request->nis . '@student.sch.id';

        // Pastikan email tidak bentrok
        $emailBase = $email;
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $emailBase . $counter++;
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $email,
            'password'  => Hash::make($request->password),
            'nis'       => $request->nis,
            'class'     => $request->class,
            'role'      => 'student',
            'status'    => 'active',
        ]);

        // Simpan ke DB, lalu arahkan ke halaman login
        return redirect('/login')
            ->with('success', 'Akun berhasil dibuat! Silakan login dengan NIS dan password Anda.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request): RedirectResponse
    {
        $userName = Auth::user()->name ?? 'User';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Sampai jumpa, ' . $userName . '!');
    }

    /**
     * Handle password reset request (placeholder)
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        return redirect()->back()
            ->with('success', 'Link reset password telah dikirim (fitur ini belum aktif).');
    }

    /**
     * Handle password reset (placeholder)
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        return redirect('/login')
            ->with('info', 'Fitur reset password belum tersedia. Hubungi admin.');
    }
}
