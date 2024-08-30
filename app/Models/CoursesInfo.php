<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesInfo extends Model
{
    use HasFactory;

    protected $table = 'course_info';

    protected $fillable = [
        'courseID',
        'yearLevel',
        'semester'
    ];


}
