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
                      <a wire:navigate href="{{ route('admin.instructors') }}">
                        <div class="card card-border-shadow-warning h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-warning"><i class='bx bxs-user-detail'></i></span>
                              </div>
                              <h4 class="ms-1 mb-0">{{ $instructors }}</h4>
                            </div>
                            <p class="mb-1">Instructors</p>
                            <p class="mb-0">
                              <small class="text-muted">Total Count</small>
                            </p>
                          </div>
                        </div>
                      </a>
                      </div>
                      <div class="col-sm-6 col-lg-3 mb-4">
                        <a wire:navigate href="{{ route('admin.courses') }}">
                        <div class="card card-border-shadow-primary h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class='bx bxs-folder-open'></i></span>
                              </div>
                              <h4 class="ms-1 mb-0">{{ $courses }}</h4>
                            </div>
                            <p class="mb-1">Courses</p>
                            <p class="mb-0">
                              <small class="text-muted">Total Count</small>
                            </p>
                          </div>
                        </div>
                      </a>
                      </div>
                      <div class="col-sm-6 col-lg-3 mb-4">
                        <a wire:navigate href="{{ route('admin.undergraduates') }}">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-danger"><i class='bx bxs-graduation'></i></span>
                              </div>
                              <h4 class="ms-1 mb-0">{{ $student->where('enrollmentStatus', 0)->where('admission_status', 0)->count() }}</h4>
                            </div>
                            <p class="mb-1">Students</p>
                            <p class="mb-0">
                              <small class="text-muted">Undergraduates</small>
                            </p>
                          </div>
                        </div>
                      </a>
                      </div>
                      <div class="col-sm-6 col-lg-3 mb-4">
                        <a wire:navigate href="{{ route('admin.graduates') }}">
                        <div class="card card-border-shadow-success h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-success"><i class='bx bxs-graduation'></i></span>
                              </div>
                              <h4 class="ms-1 mb-0">{{ $graduate }}</h4>
                            </div>
                            <p class="mb-1">Graduates</p>
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
