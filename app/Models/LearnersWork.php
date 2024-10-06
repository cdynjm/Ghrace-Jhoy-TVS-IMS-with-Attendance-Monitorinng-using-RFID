<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LearnersWork extends Model
{
    use HasFactory, SoftDeletes;

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
