<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'absence_date',
        'absence_location',
        'is_holiday',
        'absence_type',
        'attendance_in',
        'attendance_out',
        'attendance',
        'proof_of_attendance',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'attendance_id');
    }
}
