<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrading extends Model
{
    use HasFactory;

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
        'avg'
    ];

    public function Instructors() {
        return $this->hasOne(Instructors::class, 'id', 'instructor');
    }

    public function Subjects() {
        return $this->hasOne(Subjects::class, 'id', 'subjectID');
    }

}
