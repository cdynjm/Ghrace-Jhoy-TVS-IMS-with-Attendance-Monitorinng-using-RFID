<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Schedule extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->hasOne(CoursesInfo::class, 'id', 'courseInfoID')->withTrashed();
    }
}

