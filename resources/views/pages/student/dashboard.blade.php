@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Dashboard'], 
        ['icon' => '
          
            <lord-icon
              src="https://cdn.lordicon.com/xirobkro.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          
        '])
      
      <div class="content-wrapper">
        
          <div class="container-xxl flex-grow-1 container-p-y">

            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                  <li class="breadcrumb-item">
                    <a href="javascript:void(0);" class="fw-bold">Dashboard |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>
            <a href="javascript:;" id="downloadPDF" class="mb-4"><i class="fab fa-wpforms me-1 mb-4" data-value="{{ strtolower(Auth::user()->Student->firstname) }}-{{ strtolower(Auth::user()->Student->lastname) }}"></i> Download your Registration Form here!</a>

            @if(Auth::user()->Student->admission_status == 1)
                <div class="row">
                    <div class="col-md-12">                        
                        <p class="text-light fw-medium mt-2">Your Admission Application Progress</p>
                    
                        <!-- Default Wizard -->
                        <div class="col-12 mb-4">
                            <div class="bs-stepper wizard-numbered mt-2 table-responsive">
                            <div class="bs-stepper-header">

                                <div class="step" data-target="#account-details">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle 
                                    
                                    @if(
                                    
                                        Auth::user()->Student->status == 1 ||
                                        Auth::user()->Student->status == 2 ||
                                        Auth::user()->Student->status == 3 ||
                                        Auth::user()->Student->status == 4 ||
                                        Auth::user()->Student->status == 5 ||
                                        Auth::user()->Student->status == 6 ||
                                        Auth::user()->Student->status == 7
                                    
                                    ) bg-success border-success text-white @endif
                                    
                                    ">1</span>
                                    <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Registration</span>
                                    <span class="bs-stepper-subtitle">
                                        @foreach($tracker->where('tracker', 1) as $tr)
                                            {{ date('M d, Y', strtotime($tr->created_at)) }}
                                        @endforeach
                                    </span>
                                    </span>
                                </button>
                                </div>

                                <div class="line"></div>
                                <div class="step" data-target="#personal-info">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-circle 
                                        
                                        @if(
                                        
                                        Auth::user()->Student->status == 2 ||
                                        Auth::user()->Student->status == 3 ||
                                        Auth::user()->Student->status == 4 ||
                                        Auth::user()->Student->status == 5 ||
                                        Auth::user()->Student->status == 6 ||
                                        Auth::user()->Student->status == 7
                                    
                                        ) bg-success border-success text-white @endif
                                        
                                        @if(

                                        Auth::user()->Student->status == 1
                                        
                                        )
                                            bg-primary border-primary text-white
                                        @endif

                                        ">2</span>
                                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Documents</span>
                                        <span class="bs-stepper-subtitle">
                                            @foreach($tracker->where('tracker', 2) as $tr)
                                                {{ date('M d, Y', strtotime($tr->created_at)) }}
                                            @endforeach
                                        </span>
                                        </span>
                                    </button>
                                </div>

                                <div class="line"></div>
                                <div class="step" data-target="#personal-info">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-circle 
                                        
                                        @if(
                                    
                                        Auth::user()->Student->status == 3 ||
                                        Auth::user()->Student->status == 4 ||
                                        Auth::user()->Student->status == 5 ||
                                        Auth::user()->Student->status == 6 ||
                                        Auth::user()->Student->status == 7
                                    
                                        ) bg-success border-success text-white @endif
                                        
                                        @if(Auth::user()->Student->status == 2)
                                            bg-primary border-primary text-white
                                        @endif

                                        ">3</span>
                                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Pending</span>
                                        <span class="bs-stepper-subtitle">
                                            @foreach($tracker->where('tracker', 3) as $tr)
                                                {{ date('M d, Y', strtotime($tr->created_at)) }}
                                            @endforeach
                                        </span>
                                        </span>
                                    </button>
                                </div>

                                <div class="line"></div>
                                <div class="step" data-target="#personal-info">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-circle 
                                        
                                        @if(
                                    
                                        Auth::user()->Student->status == 4 ||
                                        Auth::user()->Student->status == 5 ||
                                        Auth::user()->Student->status == 6 ||
                                        Auth::user()->Student->status == 7
                                    
                                        ) bg-success border-success text-white @endif
                                        
                                        @if(Auth::user()->Student->status == 3)
                                            bg-primary border-primary text-white
                                        @endif

                                        ">4</span>
                                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Exam</span>
                                        <span class="bs-stepper-subtitle">
                                            @foreach($tracker->where('tracker', 4) as $tr)
                                                {{ date('M d, Y', strtotime($tr->created_at)) }}
                                            @endforeach
                                        </span>
                                        </span>
                                    </button>
                                </div>

                                <div class="line"></div>
                                <div class="step" data-target="#personal-info">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-circle 
                                        
                                        @if(

                                        Auth::user()->Student->status == 5 ||
                                        Auth::user()->Student->status == 6 ||
                                        Auth::user()->Student->status == 7
                                    
                                        ) bg-success border-success text-white @endif
                                        
                                        @if(Auth::user()->Student->status == 4)
                                            bg-primary border-primary text-white
                                        @endif

                                        ">5</span>
                                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">1st Interview</span>
                                        <span class="bs-stepper-subtitle">
                                            @foreach($tracker->where('tracker', 5) as $tr)
                                                {{ date('M d, Y', strtotime($tr->created_at)) }}
                                            @endforeach
                                        </span>
                                        </span>
                                    </button>
                                </div>

                                <div class="line"></div>
                                <div class="step" data-target="#personal-info">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-circle 
                                        
                                        @if(

                                        Auth::user()->Student->status == 6 ||
                                        Auth::user()->Student->status == 7
                                    
                                        ) bg-success border-success text-white @endif
                                        
                                        @if(Auth::user()->Student->status == 5)
                                            bg-primary border-primary text-white
                                        @endif

                                        ">6</span>
                                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">2nd Interview</span>
                                        <span class="bs-stepper-subtitle">
                                            @foreach($tracker->where('tracker', 6) as $tr)
                                                {{ date('M d, Y', strtotime($tr->created_at)) }}
                                            @endforeach
                                        </span>
                                        </span>
                                    </button>
                                </div>

                                <div class="line"></div>
                                <div class="step" data-target="#personal-info">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-circle 
                                        
                                        @if(
                                    
                                        Auth::user()->Student->status == 7

                                        ) bg-success border-success text-white @endif
                                        
                                        @if(Auth::user()->Student->status == 6)
                                            bg-primary border-primary text-white
                                        @endif

                                        ">7</span>
                                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Final Result</span>
                                        <span class="bs-stepper-subtitle">
                                            @foreach($tracker->where('tracker', 7) as $tr)
                                                {{ date('M d, Y', strtotime($tr->created_at)) }}
                                            @endforeach
                                        </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                        <!-- /Default Wizard -->
                    </div>
                   
                    @if(Auth::user()->Student->status == 1 && Auth::user()->Student->failed == null)
                        @include('pages.student.admission-cards.upload')
                    @endif

                    @if(Auth::user()->Student->status == 2 && Auth::user()->Student->failed == null)
                        @include('pages.student.admission-cards.pending-review')
                    @endif

                    @if(Auth::user()->Student->status == 3 && Auth::user()->Student->failed == null)
                        @include('pages.student.admission-cards.exam-schedule')
                    @endif

                    @if(Auth::user()->Student->status == 4 && Auth::user()->Student->failed == null) 
                        @include('pages.student.admission-cards.interview-schedule')
                    @endif

                    @if(Auth::user()->Student->status == 5 && Auth::user()->Student->failed == null)
                        @include('pages.student.admission-cards.second-interview-schedule')
                    @endif

                    @if((Auth::user()->Student->status == 6 || Auth::user()->Student->status == 7) && Auth::user()->Student->failed == null)
                        @include('pages.student.admission-cards.final-result')
                    @endif

                    @if(Auth::user()->Student->failed == 1)
                        @include('pages.student.admission-cards.failed')
                    @endif
                </div>
          </div>
          
          @else

          <div class="row">
            <div class="col-md-4 mb-4 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="user-avatar-section">
                      <div class=" d-flex align-items-center flex-column">
                        <img class="img-fluid rounded my-4" src="/assets/user-logo.png" height="110" width="110" alt="User avatar" />
                        <div class="user-info text-center">
                          <h5 class="mb-2">{{ Auth::user()->Student->firstname }} {{ Auth::user()->Student->middlename }} {{ Auth::user()->Student->lastname }}</h5>
                          <span class="badge bg-label-secondary">STUDENT</span>
                          @if(Auth::user()->Student->enrollmentStatus == 2 && Auth::user()->Student->diploma == 1)
                          <div class="mt-2">
                            <small class="mt-2 fw-bold">GRADUATED</small>
                         </div>
                         @elseif(Auth::user()->Student->enrollmentStatus == 2 && Auth::user()->Student->diploma == 0)
                         <div class="mt-2">
                            <small class="mt-2 fw-bold text-warning">GRADUATING</small>
                         </div>
                          @else
                          @php
                            $ordinals = [
                                1 => '1st',
                                2 => '2nd',
                                3 => '3rd',
                                4 => '4th',
                                5 => '5th',
                                6 => '6th',
                            ];

                            $yearLevelDisplay = $ordinals[Auth::user()->Student->yearLevel] ?? Auth::user()->Student->yearLevel;
                            $semesterDisplay = $ordinals[Auth::user()->Student->semester] ?? Auth::user()->Student->semester;
                        @endphp

                         @if(Auth::user()->Student->freshmen == 0)
                         
                            @if(Auth::user()->Student->semester == 3)
                                <div class="mt-2">
                                    <small class="mt-2 fw-bold">{{ $yearLevelDisplay }} Year - Summer</small>
                                </div>
                            @else
                                <div class="mt-2">
                                    <small class="mt-2 fw-bold">{{ $yearLevelDisplay }} Year - {{ $semesterDisplay }} Semester</small>
                                </div>
                            @endif

                         @else
                         <div class="mt-2">
                            <small class="mt-2 fw-bold">For Enrollment (Freshmen)</small>
                        </div>
                         @endif
                        @endif
                        <div class="mt-2">
                            <small class="mt-2 fw-normal">{{ Auth::user()->Student->LearnersCourse->Course->qualification }}</small>
                        </div>

                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-2 py-2">
                      <div class="d-flex align-items-start me-4 mt-2 gap-3">
                        @if(Auth::user()->Student->enrollmentStatus == 0)
                            <span class="badge bg-label-success p-2 rounded"><i class='bx bx-check bx-sm'></i></span>
                        @endif
                        @if(Auth::user()->Student->enrollmentStatus == 1)
                            <span class="badge bg-label-danger p-2 rounded"><i class='bx bx-minus bx-sm'></i></span>
                        @endif
                        @if(Auth::user()->Student->enrollmentStatus == 2 && Auth::user()->Student->diploma == 0)
                            <span class="badge bg-label-danger p-2 rounded"><i class='bx bx-minus bx-sm'></i></span>
                        @endif
                        @if(Auth::user()->Student->enrollmentStatus == 2 && Auth::user()->Student->diploma == 1)
                            <span class="badge bg-label-success p-2 rounded"><i class='bx bxs-graduation bx-sm'></i></span>
                        @endif
                        <div>
                          <h6 class="mb-0">Status</h6>
                          @if(Auth::user()->Student->enrollmentStatus == 2 && Auth::user()->Student->diploma == 1)
                          <small>Graduated - For Employment</small>
                          @elseif(Auth::user()->Student->enrollmentStatus == 2 && Auth::user()->Student->diploma == 0)
                          <small>Pending</small>
                          @else
                          <small>Enrollment - 
                            @if(Auth::user()->Student->enrollmentStatus == 0) Enrolled @endif
                            @if(Auth::user()->Student->enrollmentStatus == 1) Pending @endif
                            </small>
                          @endif
                        </div>
                      </div>
                      
                    </div>
                    <h6 class="pb-2 fw-normal border-bottom mb-4">Details</h6>
                    <div class="info-container">
                      <ul class="list-unstyled" style="font-size: 14px">
                        <li class="mb-3">
                            <span class="fw-bold me-2">ULI No. <span style="font-size: 11px">(Unique Learner Identifier)</span>:</span>
                            <span>{{ Auth::user()->Student->ULI }}</span>
                          </li>
                          <li class="mb-3">
                            <span class="fw-bold me-2">RFID Card No.:</span>
                            <span class="text-primary">{{ Auth::user()->Student->RFID }}</span>
                          </li>
                        <li class="mb-3">
                          <span class="fw-bold me-2">Email:</span>
                          <span>{{ Auth::user()->email }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-bold me-2">Address:</span>
                          <span>{{ Auth::user()->Student->Barangay->brgyDesc }}, {{ ucwords(strtolower(Auth::user()->Student->Municipal->citymunDesc)) }}, {{ ucwords(strtolower(Auth::user()->Student->Province->provDesc)) }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-bold me-2">BirthDate</span>
                          <span>{{ date('F d, Y', strtotime(Auth::user()->Student->birthdate)) }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-bold me-2">Birthplace:</span>
                            <span>{{ ucwords(strtolower(Auth::user()->Student->BirthMunicipal->citymunDesc)) }}, {{ ucwords(strtolower(Auth::user()->Student->BirthProvince->provDesc)) }}</span>
                          </li>
                        <li class="mb-3">
                          <span class="fw-bold me-2">Contact:</span>
                          <span>{{ Auth::user()->Student->phone }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-bold me-2">Nationality:</span>
                          <span>{{ Auth::user()->Student->nationality }}</span>
                        </li>
                        <li class="mb-3">
                          <span class="fw-bold me-2">Sex:</span>
                          <span>@if(Auth::user()->Student->sex == 1) Male @endif</span>
                          <span>@if(Auth::user()->Student->sex == 2) Female @endif</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-bold me-2">Civil Status:</span>
                            <span>@if(Auth::user()->Student->civilStatus == 1) Single @endif</span>
                            <span>@if(Auth::user()->Student->civilStatus == 2) Married @endif</span>
                            <span>@if(Auth::user()->Student->civilStatus == 2) Separated/Divorced/Annulled @endif</span>
                            <span>@if(Auth::user()->Student->civilStatus == 2) Widower @endif</span>
                            <span>@if(Auth::user()->Student->civilStatus == 2) Common Law/Live In @endif</span>
                          </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- /User Card -->
              </div>

              @php
                    $data = false;
                @endphp
                @foreach ($yearLevel->take(1) as $yl)
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <p>Recent/Current</p>
                                    <h6 class="text-sm">{{ $yl->Schedule->CourseInfo->yearLevel }} - {{ $yl->Schedule->CourseInfo->semester }}</h6>
                                    <p class="my-1">Section: {{ $yl->Schedule->section }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
                                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                                        <tr>
                                            <th class="text-nowrap"><small>Subject Code</small></th>
                                            <th class="text-nowrap"><small>Description</small></th>
                                            <th class="text-nowrap"><small>Units</small></th>
                                            <th class="text-nowrap"><small>MT</small></th>
                                            <th class="text-nowrap"><small>FT</small></th>
                                            <th class="text-nowrap"><small>AVG</small></th>
                                            <th class="text-nowrap"><small>Assessment</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalUnits = 0;
                                            $totalAvg = 0;
                                            $count = 0;
                                            $mtValues = [];
                                            $ftValues = [];
                                            $avgValues = [];
                                            $subjectCodes = [];
                                        @endphp
                                    @foreach ($studentGrading->where('studentYearLevelID', $yl->id) as $sub)
                                        <tr>
                                            <td><small>{{ $sub->Subjects->subjectCode }}</small></td>
                                            <td><small>{{ $sub->Subjects->description }}</small></td>
                                            <td><small>{{ $sub->Subjects->units }}</small></td>
                                            <td>
                                                <div>
                                                    <small class="">
                                                       {{ number_format($sub->mt, 1) }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <small class="">
                                                        {{ number_format($sub->ft, 1) }}
                                                     </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <small class="fw-bold">
                                                        {{ number_format($sub->avg, 1) }}
                                                     </small>
                                                </div>
                                            </td>
                                            <td>
                                                <small>
                                                    @if($sub->Subjects->NC == 0)
                                                    <span style="font-size: 12px">None</span>
                                                    @else
                                                        @if($sub->assessment == 0)
                                                            <i class="fa-solid fa-circle-check text-primary fw-bold"></i> <span class="ms-1" style="font-size: 12px">Not Yet Taken</span>
                                                        @endif
                                                        @if($sub->assessment == 1)
                                                            <i class="fa-solid fa-circle-check text-success fw-bold"></i> <span class="ms-1" style="font-size: 12px">COMPETENT</span>
                                                        @endif
                                                        @if($sub->assessment == 2)
                                                            <i class="fa-solid fa-circle-xmark text-danger fw-bold"></i> <span class="ms-1" style="font-size: 12px">NOT YET COMPETENT</span>
                                                        @endif
                                                    @endif
                                                </small>
                                            </td>
                                        </tr>
                                        @php
                                            $totalUnits += $sub->Subjects->units;
                                            if ($sub->avg != 0) {
                                                $totalAvg += $sub->avg;
                                                $count++;
                                            }

                                            $mtValues[] = $sub->mt;
                                            $ftValues[] = $sub->ft;
                                            $avgValues[] = $sub->avg;
                                            $subjectCodes[] = $sub->Subjects->subjectCode;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-end"><small><strong>Total Units:</strong></small></td>
                                            <td><small><strong>{{ $totalUnits }}</strong></small></td>
                                            <td colspan="2" class="text-end"><small><strong>GWA:</strong></small></td>
                                            <td><small><strong>{{ $count > 0 ? number_format($totalAvg / $count, 2) : '0.0' }}</strong></small></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                
                                <!-- Chart Container -->
                            <div id="chart-{{ $yl->id }}" class="overflow-hidden"></div>
                            
                        
                            <script>
                            
                                $(document).ready(function() {
                                    const mtValues = @json($mtValues);
                                    const ftValues = @json($ftValues);
                                    const avgValues = @json($avgValues);

                                    // Find the maximum value to calculate inverted values
                                    const maxValue = Math.max(...mtValues, ...ftValues, ...avgValues);

                                    // Invert the values and round them to a reasonable precision (e.g., 2 decimal places)
                                    const invertedMtValues = mtValues.map(value => Math.round((maxValue - value) * 100) / 100);
                                    const invertedFtValues = ftValues.map(value => Math.round((maxValue - value) * 100) / 100);
                                    const invertedAvgValues = avgValues.map(value => Math.round((maxValue - value) * 100) / 100);

                                    var options = {
                                        chart: {
                                            type: 'area',
                                            height: 300
                                        },
                                        series: [
                                            {
                                                name: 'MT',
                                                data: invertedMtValues
                                            },
                                            {
                                                name: 'FT',
                                                data: invertedFtValues
                                            },
                                            {
                                                name: 'AVG',
                                                data: invertedAvgValues
                                            }
                                        ],
                                        xaxis: {
                                            categories: @json($subjectCodes),
                                        },
                                        tooltip: {
                                            shared: true,
                                            intersect: false,
                                            y: {
                                                formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                                                    // Show the original value in the tooltip
                                                    if (seriesIndex === 0) return `${mtValues[dataPointIndex]}`;
                                                    if (seriesIndex === 1) return `${ftValues[dataPointIndex]}`;
                                                    if (seriesIndex === 2) return `${avgValues[dataPointIndex]}`;
                                                }
                                            }
                                        },
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function(val, { seriesIndex, dataPointIndex, w }) {
                                                // Display original values as data labels
                                                if (seriesIndex === 0) return mtValues[dataPointIndex];
                                                if (seriesIndex === 1) return ftValues[dataPointIndex];
                                                if (seriesIndex === 2) return avgValues[dataPointIndex];
                                            },
                                        },
                                        markers: {
                                            size: 5,
                                            hover: {
                                                size: 7
                                            }
                                        },
                                        legend: {
                                            position: 'bottom'
                                        },
                                        plotOptions: {
                                            area: {
                                                fillTo: 'origin', // Ensures that the area is filled from the baseline
                                            },
                                        },
                                    };

                                    var chart = new ApexCharts(document.querySelector("#chart-{{ $yl->id }}"), options);
                                    chart.render();
                                });
                            
                            </script>
                                
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $data = true;
                @endphp
                @endforeach

                @if($data == false)
                   
                        <div class="col-md-8 mb-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <p class="my-0">No Records Yet</p>
                                </div>
                            </div>
                        </div>
                    
                @endif

          </div>

          @endif
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
