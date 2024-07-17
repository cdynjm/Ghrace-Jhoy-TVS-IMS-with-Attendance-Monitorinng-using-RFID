<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnersWork extends Model
{
    use HasFactory;

    protected $table = 'learners_working_experience';

    protected $fillable = [
        'studentID',
        'company',
        'position',
        'dateFrom',
        'dateTo',
        'salary',
        'status',
     
    ];
}
