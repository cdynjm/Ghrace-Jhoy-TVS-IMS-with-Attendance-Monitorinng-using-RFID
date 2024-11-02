@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Schedule'], 
        ['icon' => '
          
            <lord-icon
              src="https://cdn.lordicon.com/qvyppzqz.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Schedule |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

            <div class="row">

                <form action="" id="search-schedule">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <input type="hidden" name="enrollmentStatus" value="{{ Auth::user()->Student->enrollmentStatus }}">
                            <select name="schoolYear" id="" class="form-select" required>
                                <option value="">Select School Year...</option>
                                @foreach ($schoolYears as $sy)
                                    <option value="{{ $sy->schoolYear }}">{{ $sy->schoolYear }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            <select name="yearSemester" id="" class="form-select" required>
                                <option value="">Select Year and Semester...</option>
                                @foreach ($courseInfo as $ci)
                                    <option value="{{ $aes->encrypt($ci->id) }}">{{ $ci->yearLevel }} - {{ $ci->semester }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            <button class="btn btn-success"><i class='bx bxs-search-alt-2 text-lg'></i></button>
                        </div>
                    </div>
                </form>

              
            
                    @include('data.student.schedule-subject-course-data')
            
            </div>
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
