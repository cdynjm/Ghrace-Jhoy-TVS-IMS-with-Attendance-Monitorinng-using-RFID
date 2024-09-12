<div id="view-student-attendance-data">
    @php
        $data = false;
    @endphp

    @php
    $yearLevelNames = [
        1 => '1st Year',
        2 => '2nd Year',
        3 => '3rd Year',
        4 => '4th Year',
        5 => '5th Year',
        6 => '6th Year',
    ];

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

    <div class="row">
        @foreach ($attendance as $yearLevel => $attend)

        @php
            $month = $attend->groupBy('month');
        @endphp

        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h6 class="text-sm">{{ $yearLevelNames[$yearLevel] ?? $yearLevel . 'th Year' }}</h6>
                            
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @foreach ($month as $mon => $studentAttendance)
                    <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
                        <thead class="text-dark" style="background: rgb(244, 244, 244)">
                            <tr>
                                <th class="text-nowrap">#</th>
                                <th class="text-nowrap"><small>RFID Number</small></th>
                                <th class="text-nowrap"><small>Date</small></th>
                                <th class="text-nowrap"><small>Time In</small></th>
                                <th class="text-nowrap"><small>Time Out</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td colspan="10" class="fw-bold text-primary">{{ $monthNames[$mon] }}</td>
                            </tr>
                            @foreach ($studentAttendance as $index => $sa)
                                <tr>
                                    <td><small>{{ $index +1 }}</small></td>
                                    <td><small class="fw-bold">{{ $sa->RFID }}</small></td>
                                    <td><small class="{{ $sa->date == date('Y-m-d') ? 'fw-bold text-primary' : '' }}">{{ date('M. d, Y | D', strtotime($sa->date)) }}</small></td>
                                    <td><small class="{{ $sa->date == date('Y-m-d') ? 'fw-bold text-primary' : '' }}">{{ date('h:i A', strtotime($sa->timeIn)) }}</small></td>
                                    <td><small class="{{ $sa->date == date('Y-m-d') ? 'fw-bold text-primary' : '' }}">{{ $sa->timeOut ? date('h:i A', strtotime($sa->timeOut)) : '-' }}</small></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endforeach
                </div>
            </div>
        </div>
        @php
            $data = true;
        @endphp
        @endforeach
    </div>

@if($data == false)
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header text-center">
                <p class="my-0">No Records Yet</p>
            </div>
        </div>
    </div>
</div>
@endif
</div>