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

class AttendanceController extends Controller
{
    public function RFIDattendance()
    {
        return view('pages.RFID-Attendance');
    }

    public function LogRFIDAttendance(Request $request)
    {
        $student = LearnersProfile::where('RFID', $request->RFID)->first();

        if ($student) {
            $today = Carbon::today();
            $exist = RFIDAttendance::where('RFID', $student->RFID)->whereDate('date', $today)->first();

            if (!$exist) {
                RFIDAttendance::create([
                    'studentID' => $student->id,
                    'RFID' => $student->RFID,
                    'yearLevel' => $student->yearLevel,
                    'semester' => $student->semester,
                    'month' => $today->month,
                    'year' => $today->year,
                    'date' => $today->toDateString(),
                    'timeIn' => Carbon::now()->toTimeString()
                ]);

                return response()->json(['Message' => 'Logged In'], Response::HTTP_OK);
            } else {
                if (is_null($exist->timeOut)) {
                    $exist->update([
                        'timeOut' => Carbon::now()->toTimeString()
                    ]);

                    return response()->json(['Message' => 'Logged Out'], Response::HTTP_OK);
                } else {
                    return response()->json(['Message' => 'You have already logged out for today'], Response::HTTP_OK);
                }
            }
        } else {
            return response()->json(['Message' => 'Student not found'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
