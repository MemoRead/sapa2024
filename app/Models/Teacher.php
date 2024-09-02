<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'skills',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

}
