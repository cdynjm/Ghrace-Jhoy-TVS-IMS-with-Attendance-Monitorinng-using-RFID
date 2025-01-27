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

                <div class="col-md-4 mt-2">
                    <label for="" class="mb-1"><small>Search Students</small></label>
                    <input type="text" id="search-input" class="form-control mb-3" placeholder="Type Any Keywords...">
                </div>
                <div class="col-md-4"></div>
                
                <div class="col-md-4 mb-4 text-lg-end text-center">
                    <div id="clock" class="clock fs-2 fw-bold ms-auto">
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
                            <h6 class="text-sm text-secondary">AY: {{ $schedule->Schedule->schoolYear }} - {{ $schedule->CourseInfo->semester }}</h6>
                            <div class="d-flex flex-row justify-content-between">
                                <h6 class="text-sm text-primary">{{ $schedule->CourseInfo->yearLevel }} - {{ $schedule->Schedule->section }} <small class="fw-normal text-secondary text-sm">| {{ $day }} {{ $time }}</small></h6>
                                <small>Students: <h4 class="text-lg d-inline">{{ $students->count() }} </h4></small>
                            </div>
                            <div class="fw-normal text-secondary">{{ $schedule->Subjects->subjectCode }} - {{ $schedule->Subjects->description }}</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="students-data" class="table table-sm table-hover text-nowrap" style="border-bottom: 1px solid rgb(240, 240, 240)">
                                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                                        <!-- Main Header Row -->
                                        <tr>
                                            <th>#</th>
                                            <th><small>Name</small></th>
                                            <th><small>Address</small></th>
                                            <th><small>MT</small></th>
                                            <th><small>FT</small></th>
                                            <th><small>AVG</small></th>
                                            @if($schedule->status == 1)
                                            <th colspan="5" class="text-center"><small>Today's Attendance</small></th>
                                            @else
                                            <th class="text-center"><small>View Attendances</small></th>
                                            @endif
                                        </tr>
                                
                                        @if($schedule->status == 1)
                                        <!-- Sub Header Row for Attendance -->
                                        <tr>
                                            <th colspan="6"></th> <!-- Empty cells to align with the first six columns -->
                                            <th><small class="text-capitalize">AM in</small></th>
                                            <th><small class="text-capitalize">AM out</small></th>
                                            <th><small class="text-capitalize">PM in</small></th>
                                            <th><small class="text-capitalize">PM out</small></th>
                                            <th class="text-center"><small>Attendances</small></th>
                                        </tr>
                                        @endif
                                    </thead>
                                    <tbody>
                                        @php $count = 0; @endphp
                                        @foreach ($students as $st)
                                            <tr>
                                                <td><small>{{ ++$count }}</small></td>
                                                <td><small>{{ $st->Student->lastname }}, {{ $st->Student->firstname }}, {{ $st->Student->middlename }}</small></td>
                                                <td><small>{{ $st->Student->Barangay->brgyDesc }}, {{ ucwords(strtolower($st->Student->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($st->Student->Province->provDesc)) }}</small></td>
                                                <td><small>{{ $grading->where('studentID', $st->Student->id)->first()->mt }}</small></td>
                                                <td><small>{{ $grading->where('studentID', $st->Student->id)->first()->ft }}</small></td>
                                                <td><small class="fw-bold">{{ $grading->where('studentID', $st->Student->id)->first()->avg }}</small></td>
                                                
                                                @php
                                                    $dataAt = false;
                                                @endphp
                                
                                                @foreach($attendance->where('studentID', $st->studentID) as $at)
                                                    @if(strpos($day, date('D', strtotime($at->date))) !== false && $schedule->status == 1) <!-- Check if status is not 0 -->
                                                        @php
                                                            $dataAt = true;
                                                        @endphp
                                                        <td>
                                                            <small class="{{ $at->timeInMorning ? 'text-primary' : 'text-danger' }}">
                                                                {{ $at->timeInMorning ? date('h:i A', strtotime($at->timeInMorning)) : '-' }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small class="{{ $at->timeOutMorning ? 'text-primary' : 'text-danger' }}">
                                                                {{ $at->timeOutMorning ? date('h:i A', strtotime($at->timeOutMorning)) : '-' }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small class="{{ $at->timeInAfternoon ? 'text-primary' : 'text-danger' }}">
                                                                {{ $at->timeInAfternoon ? date('h:i A', strtotime($at->timeInAfternoon)) : '-' }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small class="{{ $at->timeOutAfternoon ? 'text-primary' : 'text-danger' }}">
                                                                {{ $at->timeOutAfternoon ? date('h:i A', strtotime($at->timeOutAfternoon)) : '-' }}
                                                            </small>
                                                        </td>
                                                    @endif
                                                @endforeach
                                
                                                @if(!$dataAt && $schedule->status == 1)
                                                    <td><small class="text-danger">-</small></td>
                                                    <td><small class="text-danger">-</small></td>
                                                    <td><small class="text-danger">-</small></td>
                                                    <td><small class="text-danger">-</small></td>
                                                @endif
                                
                                                <td class="text-center">
                                                    <a wire:navigate href="{{ route('trainer.view-student-attendance', ['id' => $aes->encrypt($st->Student->id)]) }}" class="btn btn-xs btn-primary" title="View Student Attendances" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <iconify-icon icon="lets-icons:view-duotone" width="18" height="18"></iconify-icon>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                        @if ($count == 0)
                                            <tr>
                                                <td colspan="15" class="text-center"><small>No Data Found</small></td>
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
