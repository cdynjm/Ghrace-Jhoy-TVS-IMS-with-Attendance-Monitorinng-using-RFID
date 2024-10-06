<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LearnersClass extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'learners_classification';

    protected $fillable = [
        'studentID',
        'classification',
        'others',        
    ];
    
}
