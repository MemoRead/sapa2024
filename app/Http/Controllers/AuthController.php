<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Coba autentikasi
        if (Auth::attempt($credentials)) {
            // Regenerasi session
            $request->session()->regenerate();

            // Get the logged-in user
            $user = Auth::user();
            $studentId = $user->student_id;
            $teacherId = $user->teacher_id;
            $role = $user->role;

            // Log activity based on user role
            if ($role === 'admin') {
                Activity::create([
                    'user_id' => $user->id,
                    'description' => 'User admin login'
                ]);
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'teacher') {
                Activity::create([
                    'user_id' => $user->id,
                    'teacher_id' => $teacherId,
                    'description' => 'Teacher ' . $user->name . ' has login'
                ]);
                return redirect()->route('teacher.dashboard');
            } elseif ($role === 'student') {
                Activity::create([
                    'user_id' => $user->id,
                    'student_id' => $studentId,
                    'description' => 'Student ' . $user->name . ' has login'
                ]);
                return redirect()->route('student.dashboard');
            }

            return redirect()->intended('/');
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'username' => 'Username utawane Password Salah!',
        ]);
    }

    // Proses logout
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect()->route('login');
    }
}