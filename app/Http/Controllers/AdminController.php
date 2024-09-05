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

    private function getDailyAttendanceData($skillId)
    {
        return Attendance::whereHas('student', function($query) use ($skillId) {
            $query->where('skill_id', $skillId);
        })->whereDate('created_at', now()->toDateString())
        ->count();
    }

    private function getStudentsNotAttended()
    {
        return Student::whereDoesntHave('attendances', function($query) {
            $query->whereDate('created_at', now()->toDateString());
        })->get();
    }

    // Report Absensi
    public function attendanceReport()
    {
        $attendanceData = [
            'multimedia' => $this->getDailyAttendanceData(1),
            'tataBusana' => $this->getDailyAttendanceData(2),
            'pengelasan' => $this->getDailyAttendanceData(3),
        ];

        $totalAttendance = array_sum($attendanceData);

        $studentsNotAttended = $this->getStudentsNotAttended();
        
        $currentDate = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        // Mengambil semua data absensi
        $attendanceReports = Attendance::all();

        return view('admin.attendance_report', compact('attendanceReports', 'attendanceData', 'totalAttendance', 'studentsNotAttended', 'currentDate'));
    }

    // Report Jurnal
    public function journalReport()
    {
        $journalReports = Attendance::with('student')->get();
        $journals = Journal::all();

        return view('admin.journal_report', compact('journalReports', 'journals'));
    }
}