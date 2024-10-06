<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LearnersCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'learners_course';

    protected $fillable = [
        'studentID',
        'course',
        'scholarship',     
    ];

    public function Course() {
        return $this->hasOne(Courses::class, 'id', 'course')->withTrashed();
    }
}
