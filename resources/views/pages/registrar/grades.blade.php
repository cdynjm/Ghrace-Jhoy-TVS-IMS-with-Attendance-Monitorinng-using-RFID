@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.registrar.update.update-grades-modal')

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Grades'], 
        ['icon' => '
          
            <lord-icon
                src="https://cdn.lordicon.com/abwrkdvl.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Grades |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

                <div class="row">

                    <form action="" id="search-student-for-grading">
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <select name="schoolYear" id="schoolYear-grades" class="form-select" required>
                                    <option value="">Select School Year...</option>
                                    @foreach ($schoolYears as $sy)
                                        <option value="{{ $sy->schoolYear }}">{{ $sy->schoolYear }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <select name="yearSemester" id="yearSemester-grades" class="form-select" required>
                                    <option value="">Select Year and Semester...</option>
                                    @foreach ($courseInfo as $ci)
                                        <option value="{{ $aes->encrypt($ci->id) }}">{{ $ci->yearLevel }} - {{ $ci->semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <select name="subject" id="subject" class="form-select" required>
                                    <option value="">Select Subject</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            <div class="col-md-3 mb-4 d-flex">
                                <select name="section" id="section" class="form-select me-4" required>
                                    <option value="">Select Section</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <button class="btn btn-success"><i class='bx bxs-search-alt-2 text-lg'></i></button>
                            </div>
                        </div>                        
                    </form>

                 <!--    <div class="col-md-4 mb-4">
                       <input type="text" class="form-control" placeholder="Search..." id="search-grades" data-id="{{ $aes->encrypt($course->id) }}">
                    </div> -->
                    <div class="col-md-12">
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h6 class="text-sm text-uppercase">{{ $course->qualification }}</h6>
                                    </div>
                                </div>
                                <div class="table-responsive mt-2">
                                    <input type="text" id="search-input" class="form-control mb-3" placeholder="Search..." disabled>
                                   @include('data.registrar.grades-data')
                                </div>
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
