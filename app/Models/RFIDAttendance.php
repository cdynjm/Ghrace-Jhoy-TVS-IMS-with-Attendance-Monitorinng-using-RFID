<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RFIDAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rfid_attendance';

    protected $fillable = [
        'studentID',
        'RFID',
        'yearLevel',
        'semester',
        'month',
        'year',
        'date',
        'timeInMorning',
        'timeOutMorning',
        'timeInAfternoon',
        'timeOutAfternoon',
        'smsInMorning',
        'smsOutMorning',
        'smsInAfternoon',
        'smsOutAfternoon'
    ];
}
