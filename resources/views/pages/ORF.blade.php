<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ORF</title>

    <style>
        #body-orf {
            font-family: Arial, Helvetica, sans-serif
        }
        table {
            width: 100%;
            font-size: 12px;
        }
        #orf {
            font-size: 12px; 
            background-color: rgb(192, 226, 232);
            border-radius: 10px;
            border: 4px solid gray;
            text-align: center;
            padding: 10px;
            color: black;
        }
        #subjects {
            color: black;
            border-collapse: collapse;
            text-align: center;
        }
        #subjects tr th {
            border: 1px solid black;
        }
        #subjects tr td {
            border: 1px solid black;
        }
    </style>

</head>


@if(Auth::user()->role == 2)
<body id="body-orf">
    <table>
        <tr>
            <td width="10%">
                <img src="/assets/school-logo.png" width="80" alt="">
            </td>
            <td>
                <strong style="font-size: 12px; color: black;">GHRACE JHOY TECHNICAL AND VOCATIONAL SCHOOL, INC</strong>
                <div style="font-size: 12px; color: black;">Zone 2, Poblacion Sogod, Southern Leyte, 6606</div>
                <div style="font-size: 12px; color: black;">gjtvsi.2018@gmail.com</div>
            </td>
            <td>
                <div id="orf"><strong>OFFICIAL REGISTRATION FORM</strong></div>
            </td>
        </tr>
    </table>

    <table style="border: 1px solid rgb(103, 171, 205); margin-bottom: 10px">
        <tr>
            <td colspan="2">
                ULI Number:  <strong>{{ $learner->ULI }}</strong>
            </td>
            <td>
                Status: 
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Name: <strong style="text-transform: uppercase">{{ $learner->lastname }}, {{ $learner->firstname }}, {{ $learner->middlename }}</strong>
            </td>
            <td>
                Sex: <strong>{{ $learner->sex == 1 ? 'Male' : ($learner->sex == 2 ? 'Female' : 'Not Specified') }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Course: <strong>{{ $learner->LearnersCourse->Course->qualification }}</strong>
            </td>
            <td>
                BirthDate: <strong>{{ date('M d, Y', strtotime($learner->birthdate)) }}</strong>
            </td>
        </tr>
        <tr>
            <td>
                Year: <strong>{{ $schedule->CourseInfo->yearLevel }}</strong>
            </td>
            <td>
                Section: <strong>{{ $schedule->section }}</strong>
            </td>
            <td>
                Civil Status: <strong>
                    {{ 
                        $learner->civilStatus == 1 ? 'Single' : 
                        ($learner->civilStatus == 2 ? 'Married' : 
                        ($learner->civilStatus == 3 ? 'Separated/Divorced/Annulled' : 
                        ($learner->civilStatus == 4 ? 'Widower' : 
                        ($learner->civilStatus == 5 ? 'Common Law/Live In' : 'Unknown'))))
                    }}
                    </strong>
                    
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Academic Year: <strong>{{ $schedule->schoolYear }}</strong>
            </td>
            <td>
                Semester: <strong>{{ $schedule->CourseInfo->semester }}</strong>
            </td>
        </tr>
    </table>

    <table id="subjects">
        <tr style="background: rgb(252, 216, 196);">
            <th style="padding: 10px;">COURSE NO.</th>
            <th>COURSE TITLE</th>
            <th>UNITS</th>
            <th>ROOM/DAY/TIME</th>
            <th>TEACHER</th>
            <th>SIGNATURE</th>
        </tr>
        @foreach ($subjectSchedule as $sc)
            <tr>
                <td>{{ $sc->Subjects->subjectCode }}</td>
                <td style="text-align: left">{{ $sc->Subjects->description }}</td>
                <td>{{ $sc->Subjects->units }}</td>
                <td>
                    <div>
                        
                            {{ $sc->room }} | 
                            @if($sc->mon == 1)
                                Mon 
                            @endif
    
                            @if($sc->tue == 1)
                                Tue 
                            @endif
    
                            @if($sc->wed == 1)
                                Wed 
                            @endif
    
                            @if($sc->thu == 1)
                                Thu 
                            @endif
    
                            @if($sc->fri == 1)
                                Fri 
                            @endif
    
                            @if($sc->sat == 1)
                                Sat 
                            @endif
                            <br>
                            {{ $sc->fromTime != null ? date('h:i A', strtotime($sc->fromTime)) : 'none' }} - {{ $sc->toTime != null ? date('h:i A', strtotime($sc->toTime)) : 'none' }}
                        
                    </div>
                </td>
                <td>
                    {{ $sc->Instructors->instructor }}
                </td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td style="padding: 10px">
                <input type="text" value="{{ date('M d, Y', strtotime($student->created_at)) }}" style="text-align: center; border: none; border-bottom: 1px solid black; font-size: 12px;" readonly>
                <div>DATE ACCOMPLISHED</div>
            </td>
            <td style="padding: 10px">
                <input type="text" value="" style="text-align: center; border: none; border-bottom: 1px solid black; font-size: 12px;" readonly>
                <div>STUDENT'S SIGNATURE</div>
            </td>
            <td style="padding: 10px" colspan="2">
                <input type="text" value="" style="text-align: center; border: none; border-bottom: 1px solid black; font-size: 12px;" readonly>
                <div>ENROLLING OFFICER</div>
            </td>
            <td style="padding: 10px" colspan="2">
                <input type="text" value="" style="text-align: center; border: none; border-bottom: 1px solid black; font-size: 12px;" readonly>
                <div>SCHOOL REGISTRAR</div>
            </td>

        </tr>
    </table>
</body>
@endif

@if(Auth::user()->role == 4)
<body id="body-orf">
    <table>
        <tr>
            <td width="10%">
                <img src="/assets/school-logo.png" width="80" alt="">
            </td>
            <td>
                <strong style="font-size: 12px; color: black;">GHRACE JHOY TECHNICAL AND VOCATIONAL SCHOOL, INC</strong>
                <div style="font-size: 12px; color: black;">Zone 2, Poblacion Sogod, Southern Leyte, 6606</div>
                <div style="font-size: 12px; color: black;">gjtvsi.2018@gmail.com</div>
            </td>
            <td>
                <div id="orf"><strong>OFFICIAL REGISTRATION FORM</strong></div>
            </td>
        </tr>
    </table>

    <table style="border: 1px solid rgb(103, 171, 205); margin-bottom: 10px">
        <tr>
            <td colspan="2">
                ULI Number:  <strong>{{ Auth::user()->Student->ULI }}</strong>
            </td>
            <td>
                Status: 
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Name: <strong style="text-transform: uppercase">{{ Auth::user()->Student->lastname }}, {{ Auth::user()->Student->firstname }}, {{ Auth::user()->Student->middlename }}</strong>
            </td>
            <td>
                Sex: <strong>{{ Auth::user()->Student->sex == 1 ? 'Male' : (Auth::user()->Student->sex == 2 ? 'Female' : 'Not Specified') }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Course: <strong>{{ Auth::user()->Student->LearnersCourse->Course->qualification }}</strong>
            </td>
            <td>
                BirthDate: <strong>{{ date('M d, Y', strtotime(Auth::user()->Student->birthdate)) }}</strong>
            </td>
        </tr>
        <tr>
            <td>
                Year: <strong>{{ $schedule->CourseInfo->yearLevel }}</strong>
            </td>
            <td>
                Section: <strong>{{ $schedule->section }}</strong>
            </td>
            <td>
                Civil Status: <strong>
                    {{ 
                        Auth::user()->Student->civilStatus == 1 ? 'Single' : 
                        (Auth::user()->Student->civilStatus == 2 ? 'Married' : 
                        (Auth::user()->Student->civilStatus == 3 ? 'Separated/Divorced/Annulled' : 
                        (Auth::user()->Student->civilStatus == 4 ? 'Widower' : 
                        (Auth::user()->Student->civilStatus == 5 ? 'Common Law/Live In' : 'Unknown'))))
                    }}
                    </strong>
                    
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Academic Year: <strong>{{ $schedule->schoolYear }}</strong>
            </td>
            <td>
                Semester: <strong>{{ $schedule->CourseInfo->semester }}</strong>
            </td>
        </tr>
    </table>

    <table id="subjects">
        <tr style="background: rgb(252, 216, 196);">
            <th style="padding: 10px;">COURSE NO.</th>
            <th>COURSE TITLE</th>
            <th>UNITS</th>
            <th>ROOM/DAY/TIME</th>
            <th>TEACHER</th>
            <th>SIGNATURE</th>
        </tr>
        @foreach ($subjectSchedule as $sc)
            <tr>
                <td>{{ $sc->Subjects->subjectCode }}</td>
                <td style="text-align: left">{{ $sc->Subjects->description }}</td>
                <td>{{ $sc->Subjects->units }}</td>
                <td>
                    <div>
                        
                            {{ $sc->room }} | 
                            @if($sc->mon == 1)
                                Mon 
                            @endif
    
                            @if($sc->tue == 1)
                                Tue 
                            @endif
    
                            @if($sc->wed == 1)
                                Wed 
                            @endif
    
                            @if($sc->thu == 1)
                                Thu 
                            @endif
    
                            @if($sc->fri == 1)
                                Fri 
                            @endif
    
                            @if($sc->sat == 1)
                                Sat 
                            @endif
                            <br>
                            {{ $sc->fromTime != null ? date('h:i A', strtotime($sc->fromTime)) : 'none' }} - {{ $sc->toTime != null ? date('h:i A', strtotime($sc->toTime)) : 'none' }}
                        
                    </div>
                </td>
                <td>
                    {{ $sc->Instructors->instructor }}
                </td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td style="padding: 10px">
                <input type="text" value="{{ date('M d, Y', strtotime($student->created_at)) }}" style="text-align: center; border: none; border-bottom: 1px solid black; font-size: 12px;" readonly>
                <div>DATE ACCOMPLISHED</div>
            </td>
            <td style="padding: 10px">
                <input type="text" value="" style="text-align: center; border: none; border-bottom: 1px solid black; font-size: 12px;" readonly>
                <div>STUDENT'S SIGNATURE</div>
            </td>
            <td style="padding: 10px" colspan="2">
                <input type="text" value="" style="text-align: center; border: none; border-bottom: 1px solid black; font-size: 12px;" readonly>
                <div>ENROLLING OFFICER</div>
            </td>
            <td style="padding: 10px" colspan="2">
                <input type="text" value="" style="text-align: center; border: none; border-bottom: 1px solid black; font-size: 12px;" readonly>
                <div>SCHOOL REGISTRAR</div>
            </td>

        </tr>
    </table>
</body>
@endif
</html>