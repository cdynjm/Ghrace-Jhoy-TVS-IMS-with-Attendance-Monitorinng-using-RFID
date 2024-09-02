<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentYearLevel extends Model
{
    use HasFactory;

    protected $table = 'student_year_level';

    protected $fillable = [
        'studentID',
        'scheduleID',
        'courseInfoID'
    ];

    public function Schedule() {
        return $this->hasOne(Schedule::class, 'id', 'scheduleID');
    }

    public function Student() {
        return $this->hasOne(LearnersProfile::class, 'id', 'studentID');
    }
}
