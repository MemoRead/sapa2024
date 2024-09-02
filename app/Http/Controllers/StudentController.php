<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Skill;
use App\Models\Journal;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return view('student.index', compact('students'));
    }

    public function create()
    {
        $skills = Skill::all();
        return view('student.create', compact('skills'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'students.*.name' => 'required|string|max:255',
            'students.*.class' => 'required|string|in:XII 1,XII 2,XII 3',
            'students.*.skill_id' => 'required|exists:skills,id',
            'students.*.group' => 'required|string|in:Group 1,Group 2,Group 3,Group 4,Group 5,Group 6,Group 7,Group 8,Group 9,Group 10,Group 11,Group 12,Group 13,Group 14,Group 15',
        ]);

        // Loop melalui data yang sudah divalidasi dan simpan ke database
        foreach ($validatedData['students'] as $userData) {
            try {
                Student::create([
                    'name' => $userData['name'],
                    'class' => $userData['class'],
                    'skill_id' => $userData['skill_id'],
                    'group' => $userData['group'],
                ]);
            } catch (\Exception $e) {
                return redirect()->route('admin.users.student')->with('error', 'Terjadi kesalahan saat membuat pengguna: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.users.student')->with('success', 'Pengguna berhasil dibuat.');
    }

    // Upload file pengguna
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);
    
        // Handle file upload and import logic here
        // Assuming you have an import class to handle the file
        try {
            Excel::import(new StudentsImport, $request->file('file'));
    
            return redirect()->route('admin.users.student')->with('success', 'File berhasil diunggah dan data pengguna berhasil diimpor.');
        } catch (\Exception $e) {
            Log::error('Error uploading file: ' . $e->getMessage());
            return redirect()->route('admin.users.student')->with('error', 'Terjadi kesalahan saat mengunggah file: ' . $e->getMessage());
        }
    }
    
    public function dashboard()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $studentId = Auth::user()->student_id;

        // Fetch attendance records for the current month
        $attendances = Attendance::where('student_id', $studentId)
            ->where('absence_date', 'like', "$currentMonth%")
            ->with('journals') // Eager load journals
            ->get();

        // Extract journals from the loaded attendances
        $journals = $attendances->flatMap->journals;

        // Fetch all attendance records for the student
        $attendancesGet = Attendance::where('student_id', $studentId)->get();
        // Calculate total attendance count
        $totalAttendanceCount = $attendancesGet->count();

        // Calculate total journal count
        $totalJournalCount = Journal::whereHas('attendance', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->count();

        // Fetch recent activities for the logged-in student
        $recentActivities = Activity::where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->take(10) // Limit to the last 10 activities
            ->get();

        return view('student.dashboard', compact('attendances', 'journals', 'totalAttendanceCount', 'totalJournalCount', 'recentActivities'));
    }

    // Hapus pengguna dari database
    public function destroy($id)
    {
        try {
            // Find the user by ID or fail
            $student = Student::findOrFail($id);
    
            // Delete the user
            $student->delete();
    
            return redirect()->route('admin.users.student')->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.student')->with('error', 'Terjadi kesalahan saat menghapus siswa: ' . $e->getMessage());
        }
    }
}
