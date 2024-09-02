<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            ['name' => 'Alice Johnson', 'class' => 'XII 1', 'skill_id' => '1', 'group' => 'Group 1'],
            ['name' => 'Bob Brown', 'class' => 'XII 2', 'skill_id' => '2', 'group' => 'Group 2'],
        ]);
    }
}
