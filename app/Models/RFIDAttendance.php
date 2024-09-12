<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFIDAttendance extends Model
{
    use HasFactory;

    protected $table = 'rfid_attendance';

    protected $fillable = [
        'studentID',
        'RFID',
        'yearLevel',
        'semester',
        'month',
        'year',
        'date',
        'timeIn',
        'timeOut',
        'smsIn',
        'smsOut'
    ];
}
