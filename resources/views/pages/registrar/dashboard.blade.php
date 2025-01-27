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

            @if($enrollment->enable == 1)

            <div class="alert alert-success text-white alert-dismissible d-flex align-items-center shadow-sm" role="alert" style="background-color: rgba(72, 187, 120, 0.8);">
              <div>
                  <i class='bx bxs-info-circle me-1'></i>
                  <small>
                   <span class="me-2"> ENROLLMENT IS OPEN FOR NEXT SEMESTER STARTING FROM: </span> <strong>{{ date('F d, Y', strtotime($enrollment->open)) }}</strong> <span class="ms-2 me-2">UNTIL</span> <strong>{{ date('F d, Y', strtotime($enrollment->close)) }}</strong>
                  </small>
              </div>
            </div>

            @endif
            <div class="row">
              <p class="mb-3">Admission Application Summary</p>
              <div class="col-sm-6 col-lg-4 mb-4">
                  <a wire:navigate href="{{ route('registrar.unscheduled') }}">
                    <div class="card card-border-shadow-warning h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                          <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i class='bx bxs-calendar-x'></i></span>
                          </div>
                          <h4 class="ms-1 mb-0">{{ $student->where('failed', null)->where('status', 2)->count() }}</h4>
                        </div>
                        <p class="mb-0">Pending</p>
                        <p class="mb-0">
                          <small class="text-muted">Admission Application</small>
                        </p>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-sm-6 col-lg-4 mb-4">
                  <a wire:navigate href="{{ route('registrar.exam') }}">
                  <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                          <span class="avatar-initial rounded bg-label-success"><i class='bx bxs-calendar-check' ></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $student->where('failed', null)->where('status', 3)->count() }}</h4>
                      </div>
                      <p class="mb-0">For Exam</p>
                      <p class="mb-0">
                        <small class="text-muted">Admission Application</small>
                      </p>
                    </div>
                  </div>
                  </a>
                </div>
                <div class="col-sm-6 col-lg-4 mb-4">
                  <a wire:navigate href="{{ route('registrar.interview') }}">
                  <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                          <span class="avatar-initial rounded bg-label-primary"><i class='bx bxs-calendar-check' ></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $student->where('failed', null)->whereIn('status', [4,5])->count() }}</h4>
                      </div>
                      <p class="mb-0">For Interview</p>
                      <p class="mb-0">
                        <small class="text-muted">Admission Application</small>
                      </p>
                    </div>
                  </div>
                </a>
                </div>
                <div class="col-md-12">
                  <hr class="mt-2 mb-3">
                </div>
                <p class="mb-3">Enrollment & Students</p>
                <div class="col-sm-6 col-lg-4 mb-4">
                  <a wire:navigate href="{{ route('registrar.enroll-grades') }}">
                  <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                          <span class="avatar-initial rounded bg-label-danger"><i class='bx bxs-edit-alt' ></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $student->where('enrollmentStatus', 1)->count() }}</h4>
                      </div>
                      <p class="mb-0">Enrollment</p>
                      <p class="mb-0">
                        <small class="text-muted">Pending</small>
                      </p>
                    </div>
                  </div>
                </a>
                </div>
                
                <div class="col-sm-6 col-lg-4 mb-4">
                  <a wire:navigate href="{{ route('registrar.undergraduates') }}">
                  <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                          <span class="avatar-initial rounded bg-label-info"><i class='bx bxs-user-detail' ></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $student->where('enrollmentStatus', 0)->where('admission_status', 0)->count() }}</h4>
                      </div>
                      <p class="mb-0">Students</p>
                      <p class="mb-0">
                        <small class="text-muted">Enrolled</small>
                      </p>
                    </div>
                  </div>
                </a>
                </div>

                <div class="col-sm-6 col-lg-4 mb-4">
                  <a wire:navigate href="{{ route('registrar.graduates') }}">
                  <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                          <span class="avatar-initial rounded bg-label-success"><i class='bx bxs-graduation'></i></</span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $student->where('diploma', 1)->count() }}</h4>
                      </div>
                      <p class="mb-0">Graduates</p>
                      <p class="mb-0">
                        <small class="text-muted">Total</small>
                      </p>
                    </div>
                  </div>
                </a>
                </div>
          </div>

          </div>
        
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
