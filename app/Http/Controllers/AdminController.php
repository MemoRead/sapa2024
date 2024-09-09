<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Skill;
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

    // Report Absensi
    public function attendanceReport()
    {

        // Mengambil data absensi dengan pagination
        $attendanceReports = Attendance::with('student')
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(10); // Mengambil 10 data per halaman

                                        
        $currentDate = Carbon::now()->format('Y-m-d');

        // Data absensi per keterampilan
        $skills = Skill::all(); // Ambil semua keterampilan
        
        $attendanceData = [];
        $totalStudentsBySkill = [];

        foreach ($skills as $skill) {
            $students = Student::where('skill_id', $skill->id)->count();
            $attendanceCount = Attendance::whereDate('absence_date', $currentDate)
                                            ->whereHas('student', function ($query) use ($skill) {
                                                $query->where('skill_id', $skill->id);
                                            })->count();

            $attendanceData[$skill->name] = $attendanceCount;
            $totalStudentsBySkill[$skill->name] = $students;
        }

        // Siswa yang belum melakukan absensi
        $studentsNotAttended = Student::whereDoesntHave('attendances', function ($query) use ($currentDate) {
            $query->whereDate('absence_date', $currentDate);
        })->paginate(10); // Sesuaikan pagination jika diperlukan

        // Total absensi hari ini
        $totalAttendance = $attendanceReports->count();
        $totalStudents = Student::count();

        return view('admin.attendance_report', [
            'attendanceData' => $attendanceData,
            'totalStudentsBySkill' => $totalStudentsBySkill,
            'studentsNotAttended' => $studentsNotAttended,
            'attendanceReports' => $attendanceReports,
            'totalAttendance' => $totalAttendance,
            'totalStudents' => $totalStudents,
            'currentDate' => $currentDate
        ]);
    }

    // Report Jurnal
    public function journalReport()
    {
        $journalReports = Attendance::with('student')->paginate(10);
        $journals = Journal::paginate(10);

        return view('admin.journal_report', compact('journalReports', 'journals'));
    }

    private function getAttendanceData($skillId)
    {
        return Attendance::whereHas('student', function($query) use ($skillId) {
            $query->where('skill_id', $skillId);
        })->selectRaw('DATE(created_at) as date, COUNT(*) as count')->groupBy('date')->pluck('count', 'date')->toArray();
    }
}