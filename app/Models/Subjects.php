<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'courseID',
        'courseInfoID',
        'description',
        'subjectCode',
        'units'
    ];

    public function courseInfo() {
        return $this->hasOne(CourseInfo::class, 'id', 'courseInfoID');
    }
}
