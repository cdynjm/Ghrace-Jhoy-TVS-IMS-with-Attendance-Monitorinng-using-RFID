@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.admin.create.schedule-modal')
@extends('modals.admin.update.schedule-modal')

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
                        <input type="hidden" value="{{ $aes->encrypt($course->id) }}" name="id">
                        <div class="row">
                            <div class="col-md-4 mb-4">
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

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h6 class="text-sm">{{ $course->qualification }}</h6>
                                        <small class="text-danger"><span class="fw-bold text-secondary">Important: </span>Please ensure that all past schedules are archived before setting up a new schedule for the upcoming semester or academic year.</small>
                                    </div>
                                    @if(Auth::user()->role == 2)
                                    <div>
                                        <button class="btn btn-sm btn-primary shadow text-white" id="add-schedule" data-id="{{ $aes->encrypt($course->id) }}">+ Create</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @include('data.admin.schedule-subject-course-data')
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
