@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Student Attendance'], 
        ['icon' => '
          
            <lord-icon
              src="https://cdn.lordicon.com/wzwygmng.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          
        '])
      
      <div class="content-wrapper">
        
          <div class="container-xxl flex-grow-1 container-p-y">

            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                  <!--  <li class="breadcrumb-item">
                        <a wire:navigate href="{{ route('registrar.view-attendance', ['id' => $aes->encrypt2($student->LearnersCourse->course)]) }}" class="fw-bold text-primary">Go Back |</a>
                    </li> -->
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);" class="fw-bold">Attendance |</a>
                    </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

            <div class="row">

                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <a class="nav-link hide-arrow d-flex" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <span class="avatar me-2">
                                    <img src="/assets/user-logo.png" alt class="rounded-circle shadow-lg">
                                </span>
                                <span class="me-3 mt-2 fw-medium"> {{ $student->lastname }} {{ $student->firstname }} {{ $student->middlename }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <form id="search-student-attendance">
                    <input type="hidden" name="id" value="{{ $aes->encrypt($student->id) }}">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <select name="yearLevel" id="" class="form-select" required>
                                <option value="">Select Year Level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            @php
                                $monthNames = [
                                    1 => 'January',
                                    2 => 'February',
                                    3 => 'March',
                                    4 => 'April',
                                    5 => 'May',
                                    6 => 'June',
                                    7 => 'July',
                                    8 => 'August',
                                    9 => 'September',
                                    10 => 'October',
                                    11 => 'November',
                                    12 => 'December'
                                ];
                            @endphp

                            <select name="month" id="month" class="form-select" required>
                                <option value="">Select Month</option>
                                @foreach ($monthNames as $key => $mon)
                                    <option value="{{ $key }}">{{ $mon }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-4 mb-4">
                            <button class="btn btn-success"><i class='bx bxs-search-alt-2 text-lg'></i></button>
                        </div>
                    </div>
                </form>
                @include('data.trainer.view-student-attendance-data')
                
            </div>
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
