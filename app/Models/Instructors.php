<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Instructors extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instructors';

    protected $fillable = [
        'id',
        'instructor',
        'address',
        'contactNumber',
        'degree'
    ];

    public function User() {
        return $this->hasOne(User::class, 'trainerID', 'id')->withTrashed();
    }
}
