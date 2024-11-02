<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SubjectSchedule extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->hasOne(CoursesInfo::class, 'id', 'courseInfoID')->withTrashed();
    }

    public function Schedule() {
        return $this->hasOne(Schedule::class, 'id', 'scheduleID')->withTrashed();
    }

    public function Instructors() {
        return $this->hasOne(Instructors::class, 'id', 'instructor')->withTrashed();
    }

    public function Subjects() {
        return $this->hasOne(Subjects::class, 'id', 'subject')->withTrashed();
    }

    public function Courses() {
        return $this->hasOne(Courses::class, 'id', 'courseID')->withTrashed();
    }
}
