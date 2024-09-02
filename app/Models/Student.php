<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class',
        'skills',
        'group',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
