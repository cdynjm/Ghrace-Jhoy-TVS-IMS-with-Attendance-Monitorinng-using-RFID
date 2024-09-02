<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectSchedule extends Model
{
    use HasFactory;

    protected $table = 'subject_schedule';

    protected $fillable = [
        'courseID',
        'courseInfoID',
        'scheduleID',
        'subject',
        'instructor',
        'room',
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'fromTime',
        'toTime',
        'status'
    ];

    public function CourseInfo() {
        return $this->hasOne(CoursesInfo::class, 'id', 'courseInfoID');
    }

    public function Instructors() {
        return $this->hasOne(Instructors::class, 'id', 'instructor');
    }

    public function Subjects() {
        return $this->hasOne(Subjects::class, 'id', 'subject');
    }
}
