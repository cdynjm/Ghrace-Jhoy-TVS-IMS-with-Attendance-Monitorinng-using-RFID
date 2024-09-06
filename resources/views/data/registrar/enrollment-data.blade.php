<div id="enrollment-data">
    
    @php
        $yearLevelNames = [
            1 => '1st Years',
            2 => '2nd Years',
            3 => '3rd Years',
            4 => '4th Years',
        ];
    @endphp

    @foreach ($enrollees->where('freshmen', 1)->groupBy('freshmen') as $freshmen => $students)

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <p class="fw-bold text-primary">New Enrollees</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                        <tr>
                            <th class="text-nowrap">#</th>
                            <th class="text-nowrap"><small>Student Name</small></th>
                            <th class="text-nowrap"><small>Address</small></th>
                            <th class="text-nowrap"><small>Action</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $en)
                            <tr>
                                <td
                                id="{{ $aes->encrypt($en->id) }}"
                                courseID="{{ $aes->encrypt2($en->LearnersCourse->course) }}"
                                ><small>{{ $index + 1 }}</small></td>
                                <td><small>{{ $en->lastname }}, {{ $en->firstname }}, {{ $en->middlename }}</small></td>
                                <td><small>{{ $en->Barangay->brgyDesc }}, {{ ucwords(strtolower($en->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($en->Province->provDesc)) }} - {{ $en->Region->regDesc }}</small></td>
                                <td>
                                    <small>
                                        @if($en->enrollmentStatus == 1 && $en->freshmen == 1)
                                            <button class="btn btn-sm btn-success" id="enroll-student">Enroll</button>
                                        @elseif($en->enrollmentStatus == 1)
                                            <button class="btn btn-sm btn-success" id="enroll-student">Enroll for next sem</button>
                                        @elseif($en->enrollmentStatus == 2)
                                            <button class="btn btn-sm btn-primary" id="graduate-student"><iconify-icon icon="streamline:graduation-cap-solid" width="18" height="18" class="me-2"></iconify-icon> Graduate/Diploma</button>
                                        @else
                                            <span class="text-success">Currently Enrolled</span>
                                        @endif
        
                                        <a href="/messenger/{{ $en->User->id }}" class="btn btn-sm btn-primary ms-2" style="font-size: 12px"><iconify-icon icon="solar:chat-dots-bold-duotone" width="18" height="18" class="me-1"></iconify-icon> Chat</a>
                                    </small>
                                </td>                    
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
    @endforeach


    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <p class="fw-bold text-primary">Continuing</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @foreach ($enrollees->where('freshmen', 0)->groupBy('yearLevel') as $yearLevel => $enrolleesInfo)
                    @php
                        $semesters = $enrolleesInfo->groupBy('semester');
                    @endphp
                    <p class="fw-bold">{{ $yearLevelNames[$yearLevel] ?? $yearLevel . 'th Years' }}</p>
                    
                    @foreach ($semesters as $semester => $students)
                        <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
                            <thead class="text-dark" style="background: rgb(244, 244, 244)">
                                <tr>
                                    <th class="text-nowrap">#</th>
                                    <th class="text-nowrap"><small>Student Name</small></th>
                                    <th class="text-nowrap"><small>Address</small></th>
                                    <th class="text-nowrap"><small>Action</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="">
                                    <td colspan="10" class="fw-bold text-primary">{{ $semester == 1 ? '1st' : '2nd' }} Semester</td>
                                </tr>
                                @foreach ($students as $index => $en)
                                    <tr>
                                        <td
                                        id="{{ $aes->encrypt($en->id) }}"
                                        courseID="{{ $aes->encrypt2($en->LearnersCourse->course) }}"
                                        ><small>{{ $index + 1 }}</small></td>
                                        <td><small>{{ $en->lastname }}, {{ $en->firstname }}, {{ $en->middlename }}</small></td>
                                        <td><small>{{ $en->Barangay->brgyDesc }}, {{ ucwords(strtolower($en->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($en->Province->provDesc)) }} - {{ $en->Region->regDesc }}</small></td>
                                        <td>
                                            <small>
                                                @if($en->enrollmentStatus == 1 && $en->freshmen == 1)
                                                    <button class="btn btn-sm btn-success" id="enroll-student">Enroll</button>
                                                @elseif($en->enrollmentStatus == 1)
                                                    <button class="btn btn-sm btn-success" id="enroll-student">Enroll for next sem</button>
                                                @elseif($en->enrollmentStatus == 2)
                                                    <button class="btn btn-sm btn-primary" id="graduate-student"><iconify-icon icon="streamline:graduation-cap-solid" width="18" height="18" class="me-2"></iconify-icon> Graduate/Diploma</button>
                                                @else
                                                    <span class="text-success">Currently Enrolled</span>
                                                @endif

                                                <a href="/messenger/{{ $en->User->id }}" class="btn btn-sm btn-primary ms-2" style="font-size: 12px"><iconify-icon icon="solar:chat-dots-bold-duotone" width="18" height="18" class="me-1"></iconify-icon> Chat</a>
                                            </small>
                                        </td>                    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach

                    @php
                        $data = true;
                    @endphp
                @endforeach  
            </div>
        </div>
    </div>

    
</div>
