<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Form</title>

    <style>
        #content {
            font-size: 11px;
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        table tr td {
            border: 1px solid black;
        }
        table tr th {
            border: 1px solid black;
        }
        .page {
            page-break-after: always;
        }
    </style>

</head>
<body>
    <div id="content">
        <div class="page">
            <table id="table-form">
                <tr>
                    <td style="text-center">
                        <div><img src="/assets/tesda-logo.png" style="width: 40px; height: auto; display: block; margin: auto;" alt=""></div>
                    </td>
                    <td colspan="2" style="text-align: center; font-family:'Times New Roman', Times, serif">
                        <div style="font-weight: bold;">Technical Education and Skills Development</div>
                        <div>Pangasiwaan sa Edukasyong Teknikal at Pagpapaunlad ng Kasanayan</div>
                    </td>
                    <td style="text-align: center">
                        <div style="font-weight: bold"><i>MIS 03-01</i></div>
                        <div style="font-weight: bold"><i>(ver. 2021)</i></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: center; font-size: 25px; font-weight: bold">
                        <div>
                            Registration Form
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-right: none; text-align: center;">
                        <div style="font-weight: bold; font-size: 18px;">LEARNERS PROFILE FORM</div>
                    </td>
                    <td style="border-left: none; width: 150px;">
                        <div style="border: 1px solid black; padding: 35px; margin: 5px; text-align: center; font-size: 10px;">
                            I.D. Picture
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px; padding: 8px;">1. T2MIS Auto Generated</div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 3px; border-right: none;">
                        <span>
                            <span style="font-size: 8px; padding-left: 20px; padding-right: 0px;">1.1</span>
                            <span style="font-weight: bold;">
                                Unique Learner <br>
                            </span>
                            <span style="font-weight: bold; padding-left: 35px;">Identifier (ULI) Number: </span>
                        </span>
                    </td>

                    <td style="padding: 3px; border-right: none; border-left: none;" width="30%">
                        <span>

                            @php
                                // Split the ULI string into an array of characters
                                $uli = str_split($learnersProfile->ULI);
                            @endphp
                            @if(!empty($uli))
                            <table id="table-form">
                                <tr>
                                    @foreach ($uli as $index => $char)
                                        @if ($index == 10)
                                            <!-- Insert dash after the 10th cell -->
                                            <td style="text-align: center; padding: 5px; border: 1px solid black;" width="3%">
                                                <span>-</span>
                                            </td>
                                        @endif
                        
                                        <!-- Display character or add a white letter for uniform size -->
                                        <td style="padding: 5px; text-align: center; border: 1px solid black;">
                                            <span style="color: {{ empty($char) ? 'white' : 'black' }};">
                                                {{ $char ?: 'A' }}
                                            </span>
                                        </td>
                                    @endforeach
                        
                                    @for($i = count($uli); $i < 13; $i++)
                                        <!-- Add empty cells with a white letter for uniform size -->
                                        <td style="padding: 5px; text-align: center; border: 1px solid black;">
                                            <span style="color: white;">A</span>
                                        </td>
                                    @endfor
                                </tr>
                            </table>
                        @else
                            <table id="table-form">
                                <tr>
                                    @for ($i = 0; $i < 13; $i++)
                                        @if ($i == 10)
                                            <!-- Insert dash after the 10th cell -->
                                            <td style="text-align: center; padding: 5px; border: 1px solid black;" width="3%">
                                                <span>-</span>
                                            </td>
                                        @else
                                            <!-- Add empty cells with a white letter for uniform size -->
                                            <td style="padding: 5px; text-align: center; border: 1px solid black;">
                                                <span style="color: white;">A</span>
                                            </td>
                                        @endif
                                    @endfor
                                </tr>
                            </table>
                        @endif
                        
                        
                        </span>
                    </td>
                    <td colspan="2" style="padding: 3px; border-left: none;">
                        <span style="font-size: 8px;">1.2</span>
                        <span style="font-weight: bold;">Entry Date:</span>
                        <input type="text" style="width: 70%; padding: 5px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px; padding: 8px;">2. Learner/Manpower Profile</div>
                    </td>
                </tr>
                <tr>
                    <td style="border-right: none; border-bottom: none;" width="25%;">
                        <span style="font-size: 8px; padding-left: 30px; padding-right: 0px;">2.1</span>
                        <span style="font-weight: bold">Name: </span>
                    </td>
                    <td style="text-align: center; border-right: none; border-left: none; border-bottom: none; padding-top: 10px;" width="35%">
                        <span>
                            <div style="padding: 5px; border: 1px solid black;">{{ $learnersProfile->lastname }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">Last Name, Extension Name (Jr., Sr.)</label>
                        </span>
                    </td>
                    <td style="text-align: center; border-right: none; border-left: none; border-bottom: none; padding-top: 10px;">
                        <span>
                            <div style="padding: 5px; border: 1px solid black;">{{ $learnersProfile->firstname }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">First</label>
                        </span>
                    </td>
                    <td style="text-align: center; border-left: none; border-bottom: none; padding-top: 10px;">
                        <span>
                            <div style="padding: 5px; border: 1px solid black; color: {{ $learnersProfile->middlename ? 'black' : 'white' }};">
                                {{ $learnersProfile->middlename ?: '-' }}
                            </div>
                            
                            <label for="" style="font-weight: bold; font-size: 9px;">Middle</label>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="border-right: none; border-top: none;" width="25%;">
                        <span style="font-size: 8px; padding-left: 30px; padding-right: 0px;">2.1</span>
                        <span style="font-weight: bold;">Complete <br></span>
                        <span style="font-weight:bold; padding-left: 45px;">Permanent <br></span>
                        <span style="font-weight:bold; padding-left: 45px;">Mailing <br></span>
                        <span style="font-weight:bold; padding-left: 45px;">Address <br></span>
                    </td>
                    <td style="text-align: center; border-right: none; border-left: none; border-top: none;">
                        <div>
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">{{ $learnersProfile->street }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">Number, Street</label>
                        </div>
                        <div>
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">{{ ucwords(strtolower($learnersProfile->Municipal->citymunDesc)) }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">City/Muncipality</label>
                        </div>
                        <div>
                            @php
                            function formatEmailWithSpans($email)
                            {
                                // Validate the email format
                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    // Split the email into parts
                                    list($localPart, $domain) = explode('@', $email);
                                    list($domainName, $tld) = explode('.', $domain);

                                    // Return the formatted email with <span> tags
                                    return "{$localPart}<span></span>@<span></span>{$domainName}<span></span>.{$tld}";
                                }

                                // Return the original input if it's not a valid email
                                return $email;
                            }
                            @endphp

                            <!-- Example Usage -->
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">
                                <?= formatEmailWithSpans($learnersProfile->account); ?>
                            </div>

                            <label for="" style="font-weight: bold; font-size: 9px;">Email Address/Facebook Account:</label>
                        </div>

                        <script>

                            
                        </script>
                    </td>
                    <td style="text-align: center; border-right: none; border-left: none; border-top: none;">
                        <div>
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">{{ $learnersProfile->Barangay->brgyDesc }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">Barangay</label>
                        </div>
                        <div>
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">{{ ucwords(strtolower($learnersProfile->Province->provDesc)) }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">Province</label>
                        </div>
                        <div>
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">{{ $learnersProfile->phone }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">Contact No:</label>
                        </div>
                    </td>
                    <td style="text-align: center; border-left: none; border-top: none;">
                        <div>
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">{{ $learnersProfile->district }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">District</label>
                        </div>
                        <div>
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">{{ $learnersProfile->Region->regDesc }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">Region</label>
                        </div>
                        <div>
                            <div style="padding: 10px; border: 1px solid black; min-height: 40px;">{{ $learnersProfile->nationality }}</div>
                            <label for="" style="font-weight: bold; font-size: 9px;">Nationality</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px; padding: 8px;">3. Personal Information</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="font-size: 8px; padding-left: 20px;">3.1</span>
                        <span style="font-weight: bold">Sex</span>
                    </td>
                    <td>
                        <span style="font-size: 8px; padding-left: 20px;">3.2</span>
                        <span style="font-weight: bold">Civil Status</span>
                    </td>
                    <td colspan="2">
                        <span style="font-size: 8px; padding-left: 20px;">3.3</span>
                        <span style="font-weight: bold">Employment (before the training)</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding-left: 20px; margin-top: 10px;">
                            <input type="checkbox" @if($learnersProfile->sex == 1) checked @endif>
                            <label for="" style="margin-left: 10px;">Male</label>
                        </div>
                        <div style="padding-left: 20px;">
                            <input type="checkbox" @if($learnersProfile->sex == 2) checked @endif>
                            <label for="" style="margin-left: 10px;">Female</label>
                        </div>
                    </td>

                    <td>
                        <div style="padding-left: 20px; margin-top: 10px;">
                            <input type="checkbox" @if($learnersProfile->civilStatus == 1) checked @endif>
                            <label for="" style="margin-left: 10px;">Single</label>
                        </div>
                        <div style="padding-left: 20px;">
                            <input type="checkbox" @if($learnersProfile->civilStatus == 2) checked @endif>
                            <label for="" style="margin-left: 10px;">Married</label>
                        </div>
                        <div style="padding-left: 20px;">
                            <input type="checkbox" @if($learnersProfile->civilStatus == 3) checked @endif>
                            <label for="" style="margin-left: 10px;">Separated/Divorced/Anulled</label>
                        </div>
                        <div style="padding-left: 20px;">
                            <input type="checkbox" @if($learnersProfile->civilStatus == 4) checked @endif>
                            <label for="" style="margin-left: 10px;">Widower</label>
                        </div>
                        <div style="padding-left: 20px;">
                            <input type="checkbox" @if($learnersProfile->civilStatus == 5) checked @endif>
                            <label for="" style="margin-left: 10px;">Common Law/ Live-in</label>
                        </div>
                    </td>
                    <td colspan="2" width="60%">

                        <table style="border: none;">
                            <tr>
                                <td style="border: none;">
                                    <div style="margin-top: 10px; padding-left: 5px;">Employment Status</div>
                                    <div style="padding-left: 5px; margin-top: 10px;">
                                        <input type="checkbox" @if($learnersProfile->employmentStatus == 1) checked @endif>
                                        <label for="" style="">Wage- Employed</label>
                                    </div>
                                    <div style="padding-left: 5px;">
                                        <input type="checkbox" @if($learnersProfile->employmentStatus == 2) checked @endif>
                                        <label for="" style="">Underemployed</label>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div style="padding-left: 5px;">
                                        <input type="checkbox" @if($learnersProfile->employmentStatus == 3) checked @endif>
                                        <label for="" style="">Self-Employed</label>
                                    </div>
                                    <div style="padding-left: 5px;">
                                        <input type="checkbox" @if($learnersProfile->employmentStatus == 4) checked @endif>
                                        <label for="" style="">Unemployed</label>
                                    </div>
                                </td>
                                <td style="border: none;">
                                    <div style="margin-top: 10px; padding-left: 5px;">Employment Type</div>
                                    <div style="font-size: 9px; padding-left: 5px;"><i>(if Wage-employed or Underemployed)</i></div>
                                    
                                    <table style="border: none;">
                                        <td style="border: none;">
                                            <div style="padding-left: 5px; margin-top: 10px;">
                                                <input type="checkbox" @if($learnersProfile->employmentType == 1) checked @endif>
                                                <label for="" style="">None</label>
                                            </div>
                                            <div style="padding-left: 5px;">
                                                <input type="checkbox" @if($learnersProfile->employmentType == 2) checked @endif>
                                                <label for="" style="">Casual</label>
                                            </div>
                                            <div style="padding-left: 5px;">
                                                <input type="checkbox" @if($learnersProfile->employmentType == 3) checked @endif>
                                                <label for="" style="">Probationary</label>
                                            </div>
                                            <div style="padding-left: 5px;">
                                                <input type="checkbox" @if($learnersProfile->employmentType == 4) checked @endif>
                                                <label for="" style="">Contractual</label>
                                            </div>
                                        </td>
                                        <td style="border: none;">
                                            <div style="padding-left: 5px; margin-top: 10px;">
                                                <input type="checkbox" @if($learnersProfile->employmentType == 5) checked @endif>
                                                <label for="" style="">Regular</label>
                                            </div>
                                            <div style="padding-left: 5px;">
                                                <input type="checkbox" @if($learnersProfile->employmentType == 6) checked @endif>
                                                <label for="" style="">Job Order</label>
                                            </div>
                                            <div style="padding-left: 5px;">
                                                <input type="checkbox" @if($learnersProfile->employmentType == 7) checked @endif>
                                                <label for="" style="">Permanent</label>
                                            </div>
                                            <div style="padding-left: 5px;">
                                                <input type="checkbox" @if($learnersProfile->employmentType == 8) checked @endif>
                                                <label for="" style="">Temporary</label>
                                            </div>
                                        </td>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border-right: none;">
                        <span style="font-size: 8px; padding-left: 20px;">3.4</span>
                        <span style="font-weight: bold">Birthdate</span>
                    </td>
                    <td style="border-left: none;" colspan="3">
                        <table style="border: none;">
                            <tr>
                                <td style="border: none; text-align: center;">
                                    <div style="padding: 5px; border: 1px solid black;">{{ date('F', strtotime($learnersProfile->birthdate)) }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">Month of Birth</label>
                                </td>
                                <td style="border: none; text-align: center;">
                                    <div style="padding: 5px; border: 1px solid black;">{{ date('d', strtotime($learnersProfile->birthdate)) }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">Day of Birth</label>
                                </td>
                                <td style="border: none; text-align: center;">
                                    <div style="padding: 5px; border: 1px solid black;">{{ date('Y', strtotime($learnersProfile->birthdate)) }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">Year of Birth</label>
                                </td>
                                <td style="border: none; text-align: center;">
                                    <div style="padding: 5px; border: 1px solid black;">{{ $learnersProfile->age }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">Age</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border-right: none;">
                        <span style="font-size: 8px; padding-left: 20px;">3.5</span>
                        <span style="font-weight: bold">Birthplace</span>
                    </td>
                    <td style="border-left: none;" colspan="3">
                        <table style="border: none;">
                            <tr>
                                <td style="border: none; text-align: center;">
                                    <div style="padding: 5px; border: 1px solid black;">{{ ucwords(strtolower($learnersProfile->BirthMunicipal->citymunDesc)) }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">City/Municipality</label>
                                </td>
                                <td style="border: none; text-align: center;">
                                    <div style="padding: 5px; border: 1px solid black;">{{ ucwords(strtolower($learnersProfile->BirthProvince->provDesc)) }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">Province</label>
                                </td>
                                <td style="border: none; text-align: center;">
                                    <div style="padding: 5px; border: 1px solid black;">{{ $learnersProfile->BirthRegion->regDesc }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">Region</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border-right: none;" colspan="5">
                        <span style="font-size: 8px; padding-left: 20px;">3.6</span>
                        <span style="font-weight: bold">Educational Attainment Before the Training (Trainee)</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table style="border: none;">
                            <td style="border: none;">
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 1) checked @endif>
                                    <label for="" style="margin-left: 10px;">No Grade Completed</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 2) checked @endif>
                                    <label for="" style="margin-left: 10px;">Elementary Undergraduate</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 3) checked @endif>
                                    <label for="" style="margin-left: 10px;">Elementary Graduate</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 4) checked @endif>
                                    <label for="" style="margin-left: 10px;">High School Undergraduate</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 5) checked @endif>
                                    <label for="" style="margin-left: 10px;">High School Graduate</label>
                                </div>
                            </td>
                            <td style="border: none;">
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 6) checked @endif>
                                    <label for="" style="margin-left: 10px;">Junior High (K-12)</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 7) checked @endif>
                                    <label for="" style="margin-left: 10px;">Senior High (K-12)</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 8) checked @endif>
                                    <label for="" style="margin-left: 10px;">Post Secondary Non-Tertiary/Technical Vocational <br></label>
                                    <div style="padding-left: 32px;">Course Undergraduate</div>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 9) checked @endif>
                                    <label for="" style="margin-left: 10px;">Post Secondary Non-Tertiary/Technical Vocational <br></label>
                                    <div style="padding-left: 32px;">Course Graduate</div>
                                </div>
                            </td>
                            <td style="border: none;">
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 10) checked @endif>
                                    <label for="" style="margin-left: 10px;">College Undergraduate</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 11) checked @endif>
                                    <label for="" style="margin-left: 10px;">College Graduate</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 12) checked @endif>
                                    <label for="" style="margin-left: 10px;">Masteral</label>
                                </div>
                                <div style="padding-left: 5px; margin-top: 10px;">
                                    <input type="checkbox" @if($learnersProfile->education == 13) checked @endif>
                                    <label for="" style="margin-left: 10px;">Doctorate</label>
                                </div>
                            </td>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border-right: none;">
                        <span style="font-size: 8px; padding-left: 20px;">3.7</span>
                        <span style="font-weight: bold">Parent/Guardian</span>
                    </td>
                    <td colspan="3" style="border-left: none;">
                        <table style="border: none;">
                            <tr>
                                <td style="border: none; text-align: center;" colspan="2">
                                    <div style="padding: 10px; border: 1px solid black;">{{ $learnersProfile->parent }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">Name</label>
                                </td>
                                <td style="border: none; text-align: center;" colspan="2">
                                    <div style="padding: 10px; border: 1px solid black;">{{ $learnersProfile->parentAddress }}</div>
                                    <label for="" style="font-weight: bold; font-size: 9px;">Complete Permanent Mailing Addrress</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="page">
            <table style="margin-bottom: 15px;">
                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px">4. Learner/Trainee/Student (Clients) Classification: </div>
                    </td>
                </tr>

                @php
                    $class = [];
                    $class[0][1] = '4Ps Beneficiary';
                    $class[0][2] = 'Agrarian Reform Beneficiary';
                    $class[0][3] = 'Balik Probinsya';


                    $class[1][1] = 'Displaced Workers';
                    $class[1][2] = 'Drug Dependents <br> <div>Surrenderees/Surrenderers</div>';
                    $class[1][3] = 'Family Members of AFP and PNP Killed-in- <br> <div>Action</div>';

                    $class[2][1] = 'Family Members of AFP and PNP <br> <div>Wounded in-Action</div>';
                    $class[2][2] = 'Farmers and Fisherman';
                    $class[2][3] = 'Indigenous People <br> & Cultural Communities';

                    $class[3][1] = 'Industry Workers';
                    $class[3][2] = 'Inmates and Detainees';
                    $class[3][3] = 'MILF Beneficiary';

                    $class[4][1] = 'Out-of-School-Youth';
                    $class[4][2] = 'Overseas Filipino Workers (OFW) <br> <div>Dependent</div>';
                    $class[4][3] = 'RCEF-RESP';

                    $class[5][1] = 'Rebel Returnees/Decommissioned <br> <div>Combatants</div>';
                    $class[5][2] = 'Returning/Repatriated Overseas Filipino <br> <div>Workers (OFW)</div>';
                    $class[5][3] = 'Student';

                    $class[6][1] = 'TESDA Alumni';
                    $class[6][2] = 'TVET Trainers';
                    $class[6][3] = 'Uniformed Personnel';

                    $class[7][1] = 'Victim of Natural <br> Disasters and Calamities';
                    $class[7][2] = 'Wounded-in-Action <br> AFP & PNP Personnel';
                    $class[7][3] = 'Others';

                @endphp

                @for($i = 0; $i < 8; $i++)
                <tr>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox" @if($learnersClass->where('classification', $i + 1)->first()) checked @endif>
                            <label for="" style="margin-left: 10px;">{!! $class[$i][1] !!}</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox" @if($learnersClass->where('classification', $i + 9)->first()) checked @endif>
                            <label for="" style="margin-left: 10px;">{!! $class[$i][2] !!}</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox" @if($learnersClass->where('classification', $i + 17)->first()) checked @endif>
                            <label for="" style="margin-left: 10px;">{!! $class[$i][3] !!}</label>
                            @if($i == 7)
                                <input style="border: none; border-bottom: 1px solid black" @if($learnersClass->where('classification', 24)->first()) value="{{ $learnersClass->where('classification', 24)->first()->others }}" @endif/>
                                <div style="text-align: center">(Please Specify)</div>
                            @endif
                        </div>
                    </td>
                </tr>
                @endfor

                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px">5. Type of Disability (for Persons with Disability Only): <i style="font-weight: normal">To be filled by the TESDA personnel</i> </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Mental/Intellectual</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Visual Disability</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Orthopedic (Musculoskeletal) Disability</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Hearing Disability</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Speech Impairment</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Multiple Disabilities, specify</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Psychosocial Disability</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Disability Due to Chronic Illness</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 10px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Learning Disability</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px">6. Causes of Disability (for Persons with Disability Only): <i style="font-weight: normal">To be filled by the TESDA personnel</i> </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Congenital/Inborn</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Illness</label>
                        </div>
                    </td>
                    <td>
                        <div style="padding-left: 5px; margin-top: 5px;">
                            <input type="checkbox">
                            <label for="" style="margin-left: 5px;">Injury</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px">7. Name of Course/Qualification </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px; padding-left: 5px;">{{ $learnersCourse->Course->qualification }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px">8. If Scholar, What Type of Scholarship Package (TWSP, PESFA, STEP, others)? </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div style="font-weight: bold; font-size: 14px; padding-left: 5px;">{{ $learnersCourse->scholarship }}</div>
                    </td>
                </tr>
            </table>

            <table id="table-form">
                <tr>
                    <td colspan="6">
                        <div style="font-weight: bold; font-size: 14px">Working Experience </div>
                    </td>
                </tr>
                <tr>
                    <th style="text-align: center; font-weight: bold;">Name of <br>Company</th>
                    <th style="text-align: center; font-weight: bold;">Position</th>
                    <th style="text-align: center; font-weight: bold;">Inclusive date <br>From</th>
                    <th style="text-align: center; font-weight: bold;">Inclusive date To</th>
                    <th style="text-align: center; font-weight: bold;">Salary</th>
                    <th style="text-align: center; font-weight: bold;">Status</th>
                </tr>
                @php
                    $count = 3;
                @endphp
                @foreach ($learnersWork as $work)
                    @php
                        $count -= 1;
                    @endphp
                    <tr>
                        <td style="text-align: center; font-size: 10px; padding: 8px;">{{ $work->company }}</td>
                        <td style="text-align: center; font-size: 10px; padding: 8px;">{{ $work->position }}</td>
                        <td style="text-align: center; font-size: 10px; padding: 8px;">{{ date('M d, Y', strtotime($work->dateFrom)) }}</td>
                        <td style="text-align: center; font-size: 10px; padding: 8px;">{{ date('M d, Y', strtotime($work->dateTo)) }}</td>
                        <td style="text-align: center; font-size: 10px; padding: 8px;">{{ number_format($work->salary, 2) }}</td>
                        <td style="text-align: center; font-size: 10px; padding: 8px;">{{ $work->status }}</td>
                    </tr>
                @endforeach
                @for($i = 0; $i < $count; $i++)
                <tr>
                    <td style="text-align: center; padding: 15px;"></td>
                    <td style="text-align: center; padding: 15px;"></td>
                    <td style="text-align: center; padding: 15px;"></td>
                    <td style="text-align: center; padding: 15px;"></td>
                    <td style="text-align: center; padding: 15px;"></td>
                    <td style="text-align: center; padding: 15px;"></td>
                </tr>
                @endfor

                <tr>
                    <td colspan="6">
                        <div style="font-weight: bold; font-size: 14px">9. Privacy Consent and Disclaimer </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="border: none; padding-bottom: 5px;">
                        <i style="font-size: 12px; font-weight: bold">
                            I hereby attest that I have read and understood the Privacy Notice of TESDA through its website 
                            (<a href="https://www.tesda.gov.ph" target="_blank" class="text-primary text-decoration-underline">https://www.tesda.gov.ph</a>)
                            and thereby giving my consent in the processing of my personal information indicated in this Learners Profile. The processing
                            includes scholarships, employment, survey, and all other related TESDA programs that may be beneficial to my qualifications.

                        </i>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="border: none"></td>
                    <td style="border: none">
                        <input type="checkbox" @checked($learnersProfile->consent == 'Yes')>
                        <label for="">Agree</label>
                    </td>
                    <td style="border: none">
                        <input type="checkbox" @checked($learnersProfile->consent == 'No')>
                        <label for="">Disagree</label>
                    </td>
                    <td colspan="2" style="border: none"></td>
                </tr>

                <tr>
                    <td colspan="6">
                        <div style="font-weight: bold; font-size: 14px">10. Applicant's Signature </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none;"></td>
                    <td colspan="2" style="border: none; text-align: center; padding: 5px;">
                        <i>This is to certify that the information stated above is true and correct</i>
                    </td>
                    <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none; text-align: center">
                        <div style="text-transform: uppercase; text-decoration: underline; font-size: 13px;">{{ $learnersProfile->firstname }} {{ $learnersProfile->middlename }} {{ $learnersProfile->lastname }}</div>
                        <div style="font-size: 11px; font-weight: bold; margin-top: 3px;">APPLICANT'S SIGNATURE OVER PRINTED NAME</div>
                    </td>
                    <td colspan="2" style="border: none; text-align: center;">
                        <div style="text-transform: uppercase; text-decoration: underline; font-size: 13px;">{{ date('F d, Y', strtotime($learnersProfile->created_at)) }}</div>
                        <div style="font-size: 11px; font-weight: bold; margin-top: 3px;">DATE ACCOMPLISHED</div>
                    </td>
                    <td colspan="2" style="border: none; padding-right: 30px;">
                        <div style="border: 1px solid black; padding: 25px; margin: 5px; text-align: center; font-size: 10px;">
                            1x1 picture taken <br> within the last 6 <br> months
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none; text-align: center">
                        <input type="text" style="border: none; border-bottom: 2px solid black;">
                        <div style="font-size: 11px; font-weight: bold; margin-top: 3px;">REGISTRAR/SCHOOL ADMINISTRATOR</div>
                        <div style="font-size: 11px; font-weight: bold;">(Signature Over Printed Name)</div>
                    </td>
                    <td colspan="2" style="border: none; text-align: center;">
                        <input type="text" style="border: none; border-bottom: 2px solid black;">
                        <div style="font-size: 11px; font-weight: bold; margin-top: 3px;">DATE RECEIVED</div>
                    </td>
                    <td colspan="2" style="border: none; padding-right: 30px;">
                        <div style="border: 1px solid black; padding: 25px; margin: 5px; text-align: center; font-size: 10px; color: white;">THUMBMARK <br> over <br> here</div>
                        <div style="text-align: center"><b>Right Thumbmark</b></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>