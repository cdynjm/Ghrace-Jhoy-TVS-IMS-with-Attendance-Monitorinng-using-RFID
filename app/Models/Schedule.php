<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';

    protected $fillable = [
        'courseID',
        'courseInfoID',
        'section',
        'slots',
        'enrolled',
        'status',
        'schoolYear'
    ];

    public function CourseInfo() {
        return $this->hasOne(CoursesInfo::class, 'id', 'courseInfoID');
    }
}

