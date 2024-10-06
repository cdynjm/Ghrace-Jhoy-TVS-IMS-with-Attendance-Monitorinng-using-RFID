<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StudentYearLevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_year_level';

    protected $fillable = [
        'studentID',
        'scheduleID',
        'courseInfoID'
    ];

    public function Schedule() {
        return $this->hasOne(Schedule::class, 'id', 'scheduleID')->withTrashed();
    }

    public function Student() {
        return $this->hasOne(LearnersProfile::class, 'id', 'studentID')->withTrashed();
    }
}
