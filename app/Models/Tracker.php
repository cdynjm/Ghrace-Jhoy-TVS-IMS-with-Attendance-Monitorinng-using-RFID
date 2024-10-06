<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tracker extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracker';

    protected $fillable = [
        'studentID',
        'tracker'
    ];
}
