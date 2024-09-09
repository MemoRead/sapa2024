<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Activity;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Tampilkan daftar kehadiran
    public function index()
    {
        $attendances = Attendance::all();
        return view('attendances.index', compact('attendances'));
    }

    // Form untuk mencatat kehadiran baru
    public function showForm()
    {
        // $student = Student::where('id', Auth::user()->student_id)->first();
        $student = Student::with('skill')->where('id', Auth::user()->student_id)->first();

        return view('student.attendance.form', compact('student'));
    }

    // Simpan kehadiran baru ke database
    public function submitForm(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'absence_date' => 'required|date',
            'absence_time' => 'required|date_format:H:i',
            'absence_location' => 'required|string',
            'is_holiday' => 'nullable|boolean', 
            'absence_type' => ['required_if:is_holiday,0', 'in:attendance_in,attendance_out'],
            'attendance' => 'nullable|in:attendance,permission,sick',
            'proof_of_attendance' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $studentId = $user->student_id;

        $attendance = Attendance::firstOrNew([
            'student_id' => $studentId,
            'absence_date' => $request->absence_date,
        ]);

        if ($request->absence_type == 'attendance_in') {
            $attendance->attendance_in = $request->absence_time;
        } elseif ($request->absence_type == 'attendance_out') {
            $attendance->attendance_out = $request->absence_time;
        }

        $attendance->absence_location = $request->absence_location;
        $attendance->is_holiday = $request->is_holiday;
        $attendance->absence_type = $request->absence_type;
        $attendance->attendance = $request->attendance;
        $attendance->proof_of_attendance = $request->proof_of_attendance;
        $attendance->notes = $request->notes;

        try {
            $attendance->save();

            // Log activity
            Activity::create([
                'user_id' => $user->id,
                'student_id' => $studentId,
                'description' => 'Student ' . $user->name . 'Melakukan absensi pada ' . now()->format('Y-m-d') . '.'
            ]);
    
            return redirect()->route('attendance.recap')->with('success', 'Attendance submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function attendanceRecap()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Fetch the student ID associated with the logged-in user
        $user = Auth::user();
        $studentId = $user->student_id;

        // Fetch attendance records for the logged-in student
        $attendances = Attendance::with('student')
            ->where('student_id', $studentId)
            ->get();

        // Pass the attendance data to the view
        return view('student.attendance.recap', compact('attendances'));
    }

    public function studentsNotAttended(Request $request)
    {
        $currentDate = now()->format('Y-m-d');
        $studentsNotAttended = Student::whereDoesntHave('attendances', function ($query) use ($currentDate) {
            $query->where('absence_date', $currentDate);
        })->paginate(10);

        if ($request->ajax()) {
            return view('admin.report.partials.students_not_attended_table', compact('studentsNotAttended'))->render();
        }

        return view('admin.report.index', compact('studentsNotAttended'));
    }

    public function attendanceHistory(Request $request)
    {
        $skillId = $request->get('skill_id');  // mendapatkan skill_id dari request
        $date = now()->format('Y-m-d');

        // Ambil data absensi berdasarkan keterampilan siswa dan tanggal
        $attendanceReports = Attendance::whereHas('student', function($query) use ($skillId) {
            $query->where('skill_id', $skillId); // skill_id berasal dari tabel students
        })->whereDate('created_at', $date)->paginate(10);

        if ($request->ajax()) {
            return view('admin.report.partials.attendance_history_table', compact('attendanceReports'))->render();
        }

        return view('admin.report.index', compact('attendanceReports'));
    }
}