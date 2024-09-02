<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['role:admin']], function() {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
    // Manage Users
    Route::prefix('/admin/users')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/user', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::post('/user/upload', [UserController::class, 'upload'])->name('admin.users.upload');

        Route::get('/students', [StudentController::class, 'index'])->name('admin.users.student');
        Route::get('/students/create', [StudentController::class, 'create'])->name('admin.student.create');
        Route::post('/students', [StudentController::class, 'store'])->name('admin.student.store');
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('admin.student.edit');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('admin.student.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('admin.student.destroy');

        Route::post('/students/upload', [StudentController::class, 'upload'])->name('admin.student.upload');

        Route::get('/teachers', [TeacherController::class, 'index'])->name('admin.users.teacher');
    });

    // Report
    Route::prefix('/admin/reports')->group(function () {
        Route::get('/attendance', [AdminController::class, 'attendanceReport'])->name('admin.attendance.report');
        Route::get('/journal', [AdminController::class, 'journalReport'])->name('admin.journal.report');
    });
});

Route::group(['middleware' => ['role:student']], function() {
    // Dashboard Siswa
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    
    // Absensi Siswa
    Route::prefix('student/attendance')->group(function () {
        Route::get('/check', [AttendanceController::class, 'checkAttendance'])->name('attendance.check');
        Route::get('/form', [AttendanceController::class, 'showForm'])->name('attendance.form');
        Route::post('/form', [AttendanceController::class, 'submitForm'])->name('attendance.submit');
        Route::get('/recap', [AttendanceController::class, 'attendanceRecap'])->name('attendance.recap');
    });
    
    // Mengelola Jurnal
    Route::prefix('student/journal')->group(function () {
        Route::get('/', [JournalController::class, 'index'])->name('student.journal.index');
        Route::get('/create', [JournalController::class, 'create'])->name('student.journal.create');
        Route::post('/', [JournalController::class, 'store'])->name('student.journal.store');
        Route::get('/{id}/edit', [JournalController::class, 'edit'])->name('student.journal.edit');
        Route::put('/{id}', [JournalController::class, 'update'])->name('student.journal.update');
        Route::delete('/{id}', [JournalController::class, 'destroy'])->name('student.journal.destroy');
    });
});