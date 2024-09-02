<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Journal;
use App\Models\Attendance;

class AdminController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        $teachersCount = User::where('role', 'teacher')->count();
        $studentsCount = User::where('role', 'student')->count();
        $attendantRecordsCount = Attendance::count();
        $journalRecordsCount = Journal::count();

        return view('admin.dashboard', compact('teachersCount', 'studentsCount', 'attendantRecordsCount', 'journalRecordsCount'));
    }

    // Report Absensi
    public function attendanceReport()
    {
        // Mengambil semua data absensi
        $attendanceReports = Attendance::all();
        return view('admin.attendance_report', compact('attendanceReports'));
    }

    // Report Jurnal
    public function journalReport()
    {
        // Mengambil semua data jurnal
        $journalReports = Journal::all();
        return view('admin.journal_report', compact('journalReports'));
    }
}