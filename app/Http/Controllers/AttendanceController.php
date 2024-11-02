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

        // Check if an attendance record exists for today
        $attendance = RFIDAttendance::where('RFID', $student->RFID)->whereDate('date', $today)->first();

        if (!$attendance) {
            // First scan of the day
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

            if ($isMorning) {
                $this->sms->TimeIn($student);
                $attendance->update(['smsInMorning' => 1]);
            } else {
                $this->sms->TimeIn($student);
                $attendance->update(['smsInAfternoon' => 1]);
            }

            return response()->json(['Message' => $isMorning ? 'Morning Logged In' : 'Afternoon Logged In'], Response::HTTP_OK);
        } else {
            // Check for scan limits
            if ($isMorning) {
                if (!is_null($attendance->timeInMorning) && !is_null($attendance->timeOutMorning)) {
                    // Morning scan limit reached
                    return response()->json(['Message' => 'Morning scan limit reached.'], Response::HTTP_OK);
                } elseif (is_null($attendance->timeInMorning)) {
                    // First scan in the morning
                    $attendance->update(['timeInMorning' => $currentTime->toTimeString()]);
                    $this->sms->TimeIn($student);
                    $attendance->update(['smsInMorning' => 1]);
                    return response()->json(['Message' => 'Morning Logged In'], Response::HTTP_OK);
                } elseif (is_null($attendance->timeOutMorning)) {
                    // Second scan in the morning
                    $attendance->update(['timeOutMorning' => $currentTime->toTimeString()]);
                    $this->sms->TimeOut($student);
                    $attendance->update(['smsOutMorning' => 1]);
                    return response()->json(['Message' => 'Morning Logged Out'], Response::HTTP_OK);
                }
            } else {
                if (!is_null($attendance->timeInAfternoon) && !is_null($attendance->timeOutAfternoon)) {
                    // Afternoon scan limit reached
                    return response()->json(['Message' => 'Afternoon scan limit reached.'], Response::HTTP_OK);
                } elseif (is_null($attendance->timeInAfternoon)) {
                    // First scan in the afternoon
                    $attendance->update(['timeInAfternoon' => $currentTime->toTimeString()]);
                    $this->sms->TimeIn($student);
                    $attendance->update(['smsInAfternoon' => 1]);
                    return response()->json(['Message' => 'Afternoon Logged In'], Response::HTTP_OK);
                } elseif (is_null($attendance->timeOutAfternoon)) {
                    // Second scan in the afternoon
                    $attendance->update(['timeOutAfternoon' => $currentTime->toTimeString()]);
                    $this->sms->TimeOut($student);
                    $attendance->update(['smsOutAfternoon' => 1]);
                    return response()->json(['Message' => 'Afternoon Logged Out'], Response::HTTP_OK);
                }
            }
        }
    } else {
        return response()->json(['Message' => 'Student not found'], Response::HTTP_NOT_FOUND);
    }
}

}
