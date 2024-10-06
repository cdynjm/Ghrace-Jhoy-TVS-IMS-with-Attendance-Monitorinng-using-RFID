@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Students'], 
        ['icon' => '
          
            <lord-icon
              src="https://cdn.lordicon.com/xzalkbkz.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Students |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

            <div class="row">

                <div class="col-md-12 mb-4 text-center">
                    <div id="clock" class="clock fs-1 fw-bold ms-auto">
                        <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span> <span id="ampm">AM</span>
                    </div>
                    <div id="date" class="date fs-6 fw-normal ms-auto mb-3"></div>
                </div>
                <script>
                    function updateClock() {
                        const now = new Date();
                        let hours = now.getHours();
                        const minutes = String(now.getMinutes()).padStart(2, '0');
                        const seconds = String(now.getSeconds()).padStart(2, '0');
                        const ampm = hours >= 12 ? 'PM' : 'AM';
                
                        hours = hours % 12;
                        hours = hours ? hours : 12;
                        hours = String(hours).padStart(2, '0');
                
                        document.getElementById('hours').textContent = hours;
                        document.getElementById('minutes').textContent = minutes;
                        document.getElementById('seconds').textContent = seconds;
                        document.getElementById('ampm').textContent = ampm;
                    }
                
                    function updateDate() {
                        const now = new Date();
                        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        const formattedDate = now.toLocaleDateString(undefined, options);
                        document.getElementById('date').textContent = formattedDate;
                    }
                
                    updateClock();
                    updateDate();
                    setInterval(updateClock, 1000);
                    setInterval(updateDate, 60000);  // Update date every minute
                </script>
               
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-row justify-content-between">
                                <h6 class="text-sm text-primary">{{ $schedule->CourseInfo->yearLevel }} - {{ $schedule->Schedule->section }}</h6>
                                <small>Students: <h4 class="text-lg d-inline">{{ $students->count() }} </h4></small>
                            </div>
                            <div class="fw-normal text-secondary">{{ $schedule->Subjects->subjectCode }} - {{ $schedule->Subjects->description }}</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="course-data" class="table table-sm table-hover text-nowrap" style="border-bottom: 1px solid rgb(240, 240, 240)">
                                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                                        <tr>
                                            <th>#</th>
                                            <th><small>Name</small></th>
                                            <th><small>Address</small></th>
                                            <th><small>MT</small></th>
                                            <th><small>FT</small></th>
                                            <th><small>AVG</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $count = 0; @endphp
                                        @foreach ($students as $st)
                                            <tr>
                                                <td><small>{{ ++$count }}</small></td>
                                                <td><small>{{ $st->Student->lastname }}, {{ $st->Student->firstname }}, {{ $st->Student->middlename }}</small></td>
                                                <td><small>{{ $st->Student->Barangay->brgyDesc }}, {{ ucwords(strtolower($st->Student->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($st->Student->Province->provDesc)) }}</small></td>
                                                <td>
                                                    <small>
                                                        {{ $grading->where('studentID', $st->Student->id)->first()->mt }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <small>
                                                        {{ $grading->where('studentID', $st->Student->id)->first()->ft }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <small class="fw-bold">
                                                        {{ $grading->where('studentID', $st->Student->id)->first()->avg }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($count == 0)
                                            <tr>
                                                <td colspan="6" class="text-center"><small>No Data Found</small></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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
