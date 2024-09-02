<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Imports\UsersImport;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    // Tampilkan daftar pengguna
    public function index()
    {
        $users = User::all(); // Ambil data pengguna dari database
        return view('admin.users.index', compact('users'));
    }

    // Form untuk membuat pengguna baru
    public function create()
    {
        $teachers = Teacher::all(); // Ambil data guru dari database
        $students = Student::all(); // Ambil data siswa dari database
        
        return view('admin.users.create', compact('teachers', 'students'));
    }

    // Simpan pengguna baru ke database
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'users.*.name' => 'required|string|max:255',
            'users.*.username' => 'required|string|max:255|unique:users,username',
            'users.*.password' => 'required|string|min:8',
            'users.*.role' => 'required|string|in:admin,teacher,student',
            'users.*.teacher_id' => 'nullable|exists:teachers,id',
            'users.*.student_id' => 'nullable|exists:students,id',
        ]);

        // Loop melalui data yang sudah divalidasi dan simpan ke database
        foreach ($validatedData['users'] as $userData) {
            User::create([
                'name' => $userData['name'],
                'username' => $userData['username'],
                'password' => bcrypt($userData['password']),
                'teacher_id' => $userData['teacher_id'],
                'student_id' => $userData['student_id'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    // Upload file pengguna
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
        ]);

        // Handle the file upload
        $file = $request->file('file');
        
        // Jika menggunakan Laravel Excel
        Excel::import(new UsersImport, $file);

        return redirect()->route('admin.users.index')->with('success', 'Users data uploaded successfully.');
    }

    // Form untuk mengedit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id); // Ambil data pengguna dari database berdasarkan ID
        return view('admin.users.edit', compact('user'));
    }

    // Update pengguna ke database
    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:admin,teacher,student',
            'teacher_id' => 'nullable|exists:teachers,id',
            'student_id' => 'nullable|exists:students,id',
        ]);

        // Update pengguna di database
        $user = User::findOrFail($id);
        $user->update([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'password' => $validatedData['password'] ? bcrypt($validatedData['password']) : $user->password,
            'role' => $validatedData['role'],
            'teacher_id' => $validatedData['teacher_id'],
            'student_id' => $validatedData['student_id'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Hapus pengguna dari database
    public function destroy($id)
    {
        try {
            // Find the user by ID or fail
            $user = User::findOrFail($id);
    
            // Delete the user
            $user->delete();
    
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', 'Terjadi kesalahan saat menghapus pengguna: ' . $e->getMessage());
        }
    }
}