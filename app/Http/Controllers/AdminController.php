<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Journal;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        $teachersCount = User::where('role', 'teacher')->count();
        $studentsCount = User::where('role', 'student')->count();
        $attendantRecordsCount = Attendance::count();
        $journalRecordsCount = Journal::count();

        $recentActivities = Activity::orderBy('created_at', 'desc')->take(10)->get();

        $attendanceData = [
            'multimedia' => $this->getAttendanceData(1),
            'tataBusana' => $this->getAttendanceData(2),
            'pengelasan' => $this->getAttendanceData(3),
        ];

        return view('admin.dashboard', compact('teachersCount', 'studentsCount', 'attendantRecordsCount', 'journalRecordsCount', 'recentActivities', 'attendanceData'));
    }

    private function getAttendanceData($skillId)
    {
        return Attendance::whereHas('student', function($query) use ($skillId) {
            $query->where('skill_id', $skillId);
        })->selectRaw('DATE(created_at) as date, COUNT(*) as count')->groupBy('date')->pluck('count', 'date')->toArray();
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