@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

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
                    <a href="javascript:void(0);" class="fw-bold">Schedules |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-4 mt-2">
                    <label for="" class="mb-1"><small>Search Schedules</small></label>
                    <input type="text" id="search-schedule" class="form-control mb-3" placeholder="Type Any Keywords...">
                </div>
                <div class="col-md-4 mb-4">
                    
                </div>
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

                @php
                $days = [
                    'mon' => 'Monday',
                    'tue' => 'Tuesday',
                    'wed' => 'Wednesday',
                    'thu' => 'Thursday',
                    'fri' => 'Friday',
                    'sat' => 'Saturday'
                ];
            @endphp
            
            <div class="col-md-12">
                <h6>CURRENT SCHEDULE | 
                    <span class="text-primary">
                        AY: {{ $schedule->isNotEmpty() && $schedule->first()->Schedule->schoolYear ? $schedule->first()->Schedule->schoolYear : '-' }}
                    </span>
                </h6>
            </div>
            
            @php
                $data = false;
            @endphp
            @foreach ($days as $day => $label)
                @foreach ($schedule->where($day, 1)->groupBy($day) as $dayData)
                @php
                    $data = true;
                @endphp
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-row justify-content-between">
                                <h6 class="text-sm text-primary">{{ $label }}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-sm table-hover text-nowrap schedule-data" style="border-bottom: 1px solid rgb(240, 240, 240)">
                                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                                        <tr>
                                            <th>#</th>
                                            <th><small>Year, Sem & Section</small></th>
                                            <th><small>Subject Code</small></th>
                                            <th><small>Description</small></th>
                                            <th><small>Time</small></th>
                                            <th><small>Room</small></th>
                                            <th><small>Major</small></th>
                                            <th><small>Action</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $count = 0; @endphp
                                        @foreach ($dayData->sortBy('fromTime') as $sc)
                                            <tr>
                                                <td><small>{{ ++$count }}</small></td>
                                                <td><small>{{ $sc->CourseInfo->yearLevel }} | {{ $sc->CourseInfo->semester }} | {{ $sc->Schedule->section }}</small></td>
                                                
                                                <td><small>{{ $sc->Subjects->subjectCode }}</small></td>
                                                <td><small>{{ $sc->Subjects->description }}</small></td>
                                                <td><small>{{ date('h:i A', strtotime($sc->fromTime)) }} - {{ date('h:i A', strtotime($sc->toTime)) }}</small></td>
                                                <td><small>{{ $sc->room }}</small></td>
                                                <td><small class="fw-bold">{{ $sc->Courses->qualification }}</small></td>
                                                <td>
                                                    <small>
                                                        <a wire:navigate href="{{ route('trainer.students', ['id' => $aes->encrypt($sc->id), 'scheduleID' => $aes->encrypt($sc->scheduleID), 'courseInfoID' => $aes->encrypt($sc->courseInfoID), 'subjectID' => $aes->encrypt($sc->subject)]) }}" class="btn btn-xs btn-primary me-1"><iconify-icon icon="lets-icons:view-duotone" width="18" height="18" class="me-1"></iconify-icon> View Students</a>
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
                @endforeach
            @endforeach
            
            @if($data == false)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <small>There is no schedule available at the moment. Please wait for the registrar to release the upcoming semester’s schedule</small>
                        </div>
                    </div>
                </div>
            @endif
              

            </div>

        </div>
        
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
