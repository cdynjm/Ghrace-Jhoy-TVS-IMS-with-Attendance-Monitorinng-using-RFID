<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnersClass extends Model
{
    use HasFactory;
    
    protected $table = 'learners_classification';

    protected $fillable = [
        'studentID',
        'classification',
        'others',        
    ];
    
}
