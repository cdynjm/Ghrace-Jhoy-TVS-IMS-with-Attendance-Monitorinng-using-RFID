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
                                        Auth::user()->Student->status == 6
                                    
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
                                        Auth::user()->Student->status == 6
                                    
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
                                        Auth::user()->Student->status == 6
                                    
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
                                        Auth::user()->Student->status == 6
                                    
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
                                        Auth::user()->Student->status == 6
                                    
                                        ) bg-success border-success text-white @endif
                                        
                                        @if(Auth::user()->Student->status == 4)
                                            bg-primary border-primary text-white
                                        @endif

                                        ">5</span>
                                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Interview</span>
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
                                    
                                        Auth::user()->Student->status == 6

                                        ) bg-success border-success text-white @endif
                                        
                                        @if(Auth::user()->Student->status == 5)
                                            bg-primary border-primary text-white
                                        @endif

                                        ">6</span>
                                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Final Result</span>
                                        <span class="bs-stepper-subtitle">
                                            @foreach($tracker->where('tracker', 6) as $tr)
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
                   
                    @if(Auth::user()->Student->status == 1)
                        @include('pages.student.admission-cards.upload')
                    @endif

                    @if(Auth::user()->Student->status == 2)
                        @include('pages.student.admission-cards.pending-review')
                    @endif

                    @if(Auth::user()->Student->status == 3)
                        @include('pages.student.admission-cards.exam-schedule')
                    @endif

                    @if(Auth::user()->Student->status == 4)
                        @include('pages.student.admission-cards.interview-schedule')
                    @endif

                    @if(Auth::user()->Student->status == 5 || Auth::user()->Student->status == 6)
                        @include('pages.student.admission-cards.final-result')
                    @endif
                </div>
          </div>
          @endif
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
