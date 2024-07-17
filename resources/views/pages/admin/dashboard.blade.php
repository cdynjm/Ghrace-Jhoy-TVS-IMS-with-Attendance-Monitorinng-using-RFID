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
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card card-border-shadow-warning h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-warning"><i class='bx bxs-user-detail'></i></span>
                              </div>
                              <h4 class="ms-1 mb-0">0</h4>
                            </div>
                            <p class="mb-1">Trainers</p>
                            <p class="mb-0">
                              <small class="text-muted">Total Count</small>
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card card-border-shadow-success h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-success"><i class='bx bxs-folder-open'></i></span>
                              </div>
                              <h4 class="ms-1 mb-0">0</h4>
                            </div>
                            <p class="mb-1">Courses</p>
                            <p class="mb-0">
                              <small class="text-muted">Total Count</small>
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card card-border-shadow-danger h-100">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-danger"><i class='bx bxs-graduation'></i></span>
                              </div>
                              <h4 class="ms-1 mb-0">0</h4>
                            </div>
                            <p class="mb-1">Students</p>
                            <p class="mb-0">
                              <small class="text-muted">Undergraduates</small>
                            </p>
                          </div>
                        </div>
                      </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6>Recent Logs</h6>
                        
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-sm" style="border-bottom: 1px solid rgb(240, 240, 240)">
                                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                                        <tr>
                                            <th>#</th>
                                            <th width="50%"><small>Name</small></th>
                                            <th><small>Logged On</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
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
