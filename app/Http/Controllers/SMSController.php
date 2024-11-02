<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SMSToken;
use Illuminate\Support\Carbon;
use App\Models\LearnersProfile;

class SMSController extends Controller
{
    public function sms() { return SMSToken::first(); }

    public function TimeIn($student) {

        $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $student->parentContact;
        $sms = 'Greetings Mr/Mrs. '.$student->parent.',\n\n We are pleased to inform you that your child ['.$student->firstname.' '.$student->lastname.'] has entered the school on '.date('M d, Y - l').' at '.date('h:i A').', and their attendance has been recorded via the RFID system. If you have any questions, please feel free to reach out. Thank you for your support!\n\nGJTVS Inc.';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
    }

    public function TimeOut($student) {

        $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $student->parentContact;
        $sms = 'Greetings Mr/Mrs. '.$student->parent.',\n\n We are pleased to inform you that your child ['.$student->firstname.' '.$student->lastname.'] has left the school on '.date('M d, Y - l').' at '.date('h:i A').'. Their attendance has been recorded via the RFID system. If you have any questions, please feel free to reach out. Thank you for your support!\n\nGJTVS Inc.';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
    }

    public function examSchedule($date, $student) {

        $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $student->phone;
        $sms = 'Greetings '.$student->firstname.' '.$student->lastname.',\n\nWe are pleased to inform you that you have been scheduled for your entrance exam on '.date('F d, Y', strtotime($date)).'  which will take place at Ghrace Jhoy Technical Vocational School. Please bring any required documents for verification. We wish you the best of luck in your exam preparation and look forward to welcoming you to our institution.\n\nBest Regards,\nGJTVSI Registrar';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

    }

    public function interviewSchedule($date, $student) {

        $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $student->phone;
        $sms = 'Greetings '.$student->firstname.' '.$student->lastname.',\n\nWe are pleased to inform you that you have been scheduled for your 1st Interview on '.date('F d, Y', strtotime($date)).'  which will take place at Ghrace Jhoy Technical Vocational School. Please bring any required documents for verification. We wish you the best of luck in your interview preparation and look forward to welcoming you to our institution.\n\nBest Regards,\nGJTVSI Registrar';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

    }

    public function secondInterviewSchedule($date, $student) {

        $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $student->phone;
        $sms = 'Greetings '.$student->firstname.' '.$student->lastname.',\n\nWe are pleased to inform you that you have been scheduled for your 2nd Interview on '.date('F d, Y', strtotime($date)).'  which will take place at Ghrace Jhoy Technical Vocational School. Please bring any required documents for verification. We wish you the best of luck in your interview preparation and look forward to welcoming you to our institution.\n\nBest Regards,\nGJTVSI Registrar';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

    }

    public function admissionPassed($student) {

        $mobile_iden = $this->sms()->mobile_identity;
        $mobile_token = $this->sms()->access_token;

        $addresses = $student->phone;
        $sms = 'Greetings '.$student->firstname.' '.$student->lastname.',\n\nWe are pleased to inform you that you have successfully passed the admission application. You are now ready to proceed with the enrollment. Please visit the portal and log in with your account to procced.\n\nBest Regards,\nGJTVSI Registrar';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pushbullet.com/v2/texts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"data\":{\"addresses\":[\"$addresses\"],\"message\":\"$sms\",\"target_device_iden\":\"$mobile_iden\"}}");

        $headers = []; 
        $headers[] = 'Access-Token: '.$mobile_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

    }
}
