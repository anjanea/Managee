<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        if (!session()->has('url.intended')) {
            $urlPrevious = url()->previous();
            // Jangan simpan jika URL sebelumnya adalah login, register, atau logout
            if ($urlPrevious && !str_contains($urlPrevious, '/login') && !str_contains($urlPrevious, '/register')) {
                session(['url.intended' => $urlPrevious]);
            }
        }
        return view('auth.login');
    }

    /**
     * Process authentication request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:user,owner'],
        ], [
            'email.required' => 'Surel wajib diisi.',
            'email.email' => 'Format surel tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'role.required' => 'Peran masuk wajib ditentukan.',
        ]);

        // Exclude role from credentials passed to Auth::attempt directly, but verify it manually
        $attemptCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($attemptCredentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if role matches selected option
            if ($user->role !== $credentials['role']) {
                Auth::logout();
                return back()->withErrors([
                    'role_error' => 'Akun Anda tidak terdaftar sebagai ' . ($credentials['role'] === 'owner' ? 'Pemilik Properti (Owner)' : 'Penyewa') . '.',
                ])->withInput($request->only('email', 'role'));
            }

            $request->session()->regenerate();

            if ($user->role === 'owner') {
                return redirect('/owner/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Surel atau kata sandi yang Anda masukkan salah.',
        ])->withInput($request->only('email', 'role'));
    }

    /**
     * Display the registration form.
     */
    public function showRegisterForm()
    {
        if (!session()->has('url.intended')) {
            $urlPrevious = url()->previous();
            if ($urlPrevious && !str_contains($urlPrevious, '/login') && !str_contains($urlPrevious, '/register')) {
                session(['url.intended' => $urlPrevious]);
            }
        }
        return view('auth.register');
    }

    /**
     * Process registration request for users.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat surel wajib diisi.',
            'email.email' => 'Format surel tidak valid.',
            'email.unique' => 'Surel ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal harus terdiri dari 8 karakter.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Public registration is only for regular users
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $role = Auth::check() ? Auth::user()->role : 'user';

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'owner') {
            return redirect()->route('login')->withErrors(['role_error' => 'Anda telah berhasil keluar dari dashboard.']);
        }

        return redirect('/');
    }

    /**
     * Display the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Process forgot password request (simulation).
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat surel wajib diisi.',
            'email.email' => 'Format surel tidak valid.',
        ]);

        // Simulating checking if the user exists
        $userExists = User::where('email', $request->email)->exists();

        if (!$userExists) {
            return back()->withErrors([
                'email' => 'Alamat surel tidak terdaftar dalam sistem kami.',
            ])->withInput();
        }

        return back()->with('status', 'Kami telah mengirimkan tautan atur ulang kata sandi ke surel Anda!');
    }
}
