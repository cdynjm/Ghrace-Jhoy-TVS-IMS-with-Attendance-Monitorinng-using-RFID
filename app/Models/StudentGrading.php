<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StudentGrading extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_grading';

    protected $fillable = [
        'studentYearLevelID',
        'studentID',
        'courseInfoID',
        'description',
        'subjectCode',
        'subjectID',
        'instructor',
        'mt',
        'ft',
        'avg',
        'assessment'
    ];

    public function Instructors() {
        return $this->hasOne(Instructors::class, 'id', 'instructor')->withTrashed();
    }

    public function Subjects() {
        return $this->hasOne(Subjects::class, 'id', 'subjectID')->withTrashed();
    }

    public function StudentYearLevel() {
        return $this->belongsTo(StudentYearLevel::class, 'studentYearLevelID')->withTrashed();
    }


}
