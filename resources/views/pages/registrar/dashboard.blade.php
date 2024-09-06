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

            <div class="row">
              <div class="col-sm-6 col-lg-3 mb-4">
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
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
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
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
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
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
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
                </div>
                
                <div class="col-sm-6 col-lg-3 mb-4">
                  <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                          <span class="avatar-initial rounded bg-label-info"><i class='bx bxs-user-detail' ></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $student->where('enrollmentStatus', 0)->count() }}</h4>
                      </div>
                      <p class="mb-0">Students</p>
                      <p class="mb-0">
                        <small class="text-muted">Enrolled</small>
                      </p>
                    </div>
                  </div>
                </div>
          </div>

          </div>
        
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
