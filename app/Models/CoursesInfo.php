<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CoursesInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'course_info';

    protected $fillable = [
        'courseID',
        'yearLevel',
        'semester'
    ];


    public function subjects() {
        return $this->hasMany(Subjects::class, 'courseInfoID')->withTrashed();
    }
    public function Courses() {
        return $this->hasMany(Courses::class, 'id', 'courseID')->withTrashed();
    }

    public function Course() {
        return $this->hasOne(Courses::class, 'id', 'courseID')->withTrashed();
    }
}
