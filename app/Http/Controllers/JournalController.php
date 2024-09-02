<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Activity;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    // Tampilkan daftar jurnal
    public function index()
    {
        // Fetch the student ID associated with the logged-in user
        $user = Auth::user();
        $studentId = $user->student_id;

        // Fetch attendance records for the logged-in student
        $attendances = Attendance::with('student')
            ->where('student_id', $studentId)
            ->get();

        // Fetch journal entries for the logged-in student
        $journals = Journal::where('student_id', $studentId)->get();

        return view('student.journal.index', compact('attendances', 'journals'));
    }

    // Form untuk menulis jurnal baru
    public function create(Request $request)
    {
        // Fetch the student ID associated with the logged-in user
        $user = Auth::user();
        $studentId = $user->student_id;

        // Fetch the attendance record for the given date
        $attendance = Attendance::where('student_id', $studentId)
            ->where('absence_date', $request->date)
            ->first();

        return view('student.journal.create', compact('attendance'));
    }

    // Simpan jurnal baru ke database
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'journal_content' => 'required|string',
        ]);

        // Fetch the student ID associated with the logged-in user
        $user = Auth::user();
        $studentId = $user->student_id;

        // Create a new journal entry
        Journal::create([
            'student_id' => $studentId,
            'attendance_id' => $request->attendance_id,
            'journal_content' => $request->journal_content,
        ]);

        // Log activity
        Activity::create([
            'user_id' => $user->id,
            'student_id' => $studentId,
            'description' => 'Student ' . $user->name . 'Membuat jurnal pada ' . now()->format('Y-m-d') . '.'
        ]);

        return redirect()->route('student.journal.index')->with('success', 'Journal entry created successfully.');
    }

    // Form untuk mengedit jurnal
    public function edit($id)
    {
        // Fetch the journal entry
        $journal = Journal::findOrFail($id);

        return view('student.journal.edit', compact('journal'));
    }

    // Update jurnal di database
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'journal_content' => 'required|string',
        ]);

        // Fetch the journal entry
        $journal = Journal::findOrFail($id);

        // Fetch the student ID associated with the logged-in user
        $user = Auth::user();
        $studentId = $user->student_id;

        // Update the journal entry
        $journal->update([
            'journal_content' => $request->journal_content,
        ]);

        // Log activity
        Activity::create([
            'user_id' => $user->id,
            'student_id' => $studentId,
            'description' => 'Student ' . $user->name . 'Melakukan update journal.'
        ]);

        return redirect()->route('student.journal.index')->with('success', 'Journal entry updated successfully.');
    }

    // Hapus jurnal dari database
    public function destroy($id)
    {
        // Fetch the journal entry
        $journal = Journal::findOrFail($id);

        // Fetch the student ID associated with the logged-in user
        $user = Auth::user();
        $studentId = $user->student_id;

        // Delete the journal entry
        $journal->delete();

        // Log activity
        Activity::create([
            'user_id' => $user->id,
            'student_id' => $studentId,
            'description' => 'Student ' . $user->name . 'Menghapus isi Jurnal pada ' . now()->format('Y-m-d') . '.'
        ]);

        return redirect()->route('student.journal.index')->with('success', 'Journal entry deleted successfully.');
    }
}