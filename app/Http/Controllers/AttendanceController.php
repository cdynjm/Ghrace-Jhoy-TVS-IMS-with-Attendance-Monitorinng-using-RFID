<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use App\Models\LearnersProfile;
use App\Models\RFIDAttendance;
use App\Http\Controllers\SMSController;

class AttendanceController extends Controller
{

    public function __construct(
        protected SMSController $sms
    ) {}

    public function RFIDattendance()
    {
        return view('pages.RFID-Attendance');
    }

    public function LogRFIDAttendance(Request $request)
{
    $student = LearnersProfile::where('RFID', $request->RFID)->where('diploma', null)->first();

    if ($student) {
        $today = Carbon::today();
        $currentTime = Carbon::now();
        $isMorning = $currentTime->lt(Carbon::createFromTime(12, 0, 0));

        $attendance = RFIDAttendance::with('student')->where('RFID', $student->RFID)->whereDate('date', $today)->first();

        if (!$attendance) {
            // Create a new attendance record if none exists for today
            $attendance = RFIDAttendance::create([
                'studentID' => $student->id,
                'RFID' => $student->RFID,
                'yearLevel' => $student->yearLevel,
                'semester' => $student->semester,
                'month' => $today->month,
                'year' => $today->year,
                'date' => $today->toDateString(),
                'timeInMorning' => $isMorning ? $currentTime->toTimeString() : null,
                'timeInAfternoon' => !$isMorning ? $currentTime->toTimeString() : null,
            ]);

            // Send SMS when logging in
            $this->sms->TimeIn($student);
            if ($isMorning) {
                $attendance->update(['smsInMorning' => 1]);
            } else {
                $attendance->update(['smsInAfternoon' => 1]);
            }

            $latestAttendance = RFIDAttendance::with('student')->where('RFID', $student->RFID)->whereDate('date', $today)->first();

            return response()->json([
                'Message' => $isMorning ? 'Morning Logged In' : 'Afternoon Logged In',
                'Log' => $latestAttendance, // Include the attendance log in the response
            ], Response::HTTP_OK);
        } else {
            // Handle case when attendance already exists for today
            if ($isMorning) {
                if (is_null($attendance->timeInMorning)) {
                    // Log the morning time-in
                    $attendance->update(['timeInMorning' => $currentTime->toTimeString()]);
                    $this->sms->TimeIn($student);
                    $attendance->update(['smsInMorning' => 1]);

                    return response()->json([
                        'Message' => 'Morning Logged In',
                        'Log' => $attendance, // Include the attendance log in the response
                    ], Response::HTTP_OK);
                } elseif (is_null($attendance->timeOutMorning)) {
                    // Log the morning time-out
                    $attendance->update(['timeOutMorning' => $currentTime->toTimeString()]);
                    $this->sms->TimeOut($student);
                    $attendance->update(['smsOutMorning' => 1]);

                    return response()->json([
                        'Message' => 'Morning Logged Out',
                        'Log' => $attendance, // Include the attendance log in the response
                    ], Response::HTTP_OK);
                } else {
                    // Inform the user that the morning log has reached its limit
                    return response()->json([
                        'Message' => 'Morning log has already been completed for today.',
                        'Log' => $attendance,
                    ], Response::HTTP_OK);
                }
            } else {
                if (is_null($attendance->timeInAfternoon)) {
                    // Log the afternoon time-in
                    $attendance->update(['timeInAfternoon' => $currentTime->toTimeString()]);
                    $this->sms->TimeIn($student);
                    $attendance->update(['smsInAfternoon' => 1]);

                    return response()->json([
                        'Message' => 'Afternoon Logged In',
                        'Log' => $attendance, // Include the attendance log in the response
                    ], Response::HTTP_OK);
                } elseif (is_null($attendance->timeOutAfternoon)) {
                    // Log the afternoon time-out
                    $attendance->update(['timeOutAfternoon' => $currentTime->toTimeString()]);
                    $this->sms->TimeOut($student);
                    $attendance->update(['smsOutAfternoon' => 1]);

                    return response()->json([
                        'Message' => 'Afternoon Logged Out',
                        'Log' => $attendance, // Include the attendance log in the response
                    ], Response::HTTP_OK);
                } else {
                    // Inform the user that the afternoon log has reached its limit
                    return response()->json([
                        'Message' => 'Afternoon log has already been completed for today.',
                        'Log' => $attendance,
                    ], Response::HTTP_OK);
                }
            }
        }
    } else {
        return response()->json(['Message' => 'Student not found'], Response::HTTP_NOT_FOUND);
    }
}



}
