<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subjects extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subjects';

    protected $fillable = [
        'courseID',
        'courseInfoID',
        'description',
        'subjectCode',
        'units',
        'NC'
    ];

    public function courseInfo() {
        return $this->hasOne(CourseInfo::class, 'id', 'courseInfoID')->withTrashed();
    }
}
