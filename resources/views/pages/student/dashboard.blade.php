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

            @if(Auth::user()->Student->admission_status == 1)
                <div class="row">
                    <div class="col-md-12">

                        <a href="javascript:;" id="downloadPDF" class="mb-4"><i class="fab fa-wpforms me-1" data-value="{{ strtolower(Auth::user()->Student->firstname) }}-{{ strtolower(Auth::user()->Student->lastname) }}"></i> Download your Registration Form here!</a>
                        
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
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="user-avatar-section">
                      <div class=" d-flex align-items-center flex-column">
                        <img class="img-fluid rounded my-4" src="/assets/user-logo.png" height="110" width="110" alt="User avatar" />
                        <div class="user-info text-center">
                          <h5 class="mb-2">{{ Auth::user()->Student->firstname }} {{ Auth::user()->Student->middlename }} {{ Auth::user()->Student->lastname }}</h5>
                          <span class="badge bg-label-secondary">STUDENT</span>
                          
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

                        <div class="mt-2">
                            <small class="mt-2 fw-bold">{{ $yearLevelDisplay }} Year - {{ $semesterDisplay }} Semester</small>
                        </div>

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
                        <div>
                          <h6 class="mb-0">Status</h6>
                          <small>Enrollment - 
                            @if(Auth::user()->Student->enrollmentStatus == 0) Enrolled @endif
                            @if(Auth::user()->Student->enrollmentStatus == 1) Pending @endif
                        </small>
                        </div>
                      </div>
                      
                    </div>
                    <h6 class="pb-2 fw-normal border-bottom mb-4">Details</h6>
                    <div class="info-container">
                      <ul class="list-unstyled" style="font-size: 14px">
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
          </div>

          @endif
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
