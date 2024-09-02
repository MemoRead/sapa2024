<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Admin User', 'username' => 'admin', 'password' => Hash::make('password'), 'role' => 'admin', 'teacher_id' => null, 'student_id' => null],
            ['name' => 'John Doe', 'username' => 'teacher1', 'password' => Hash::make('password'), 'role' => 'teacher', 'teacher_id' => 1, 'student_id' => null],
            ['name' => 'Jane Smith', 'username' => 'teacher2', 'password' => Hash::make('password'), 'role' => 'teacher', 'teacher_id' => 2, 'student_id' => null],
            ['name' => 'Student One', 'username' => 'student1', 'password' => Hash::make('password'), 'role' => 'student', 'teacher_id' => null, 'student_id' => 1],
            ['name' => 'Student Two', 'username' => 'student2', 'password' => Hash::make('password'), 'role' => 'student', 'teacher_id' => null, 'student_id' => 2],
        ]);
    }
}
