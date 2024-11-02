<div id="grades-data-instructor">
    @php
        $days = [
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday'
        ];
        $data = false;
    @endphp
    
    @foreach ($schedule->groupBy([function($sc) { return $sc->CourseInfo->yearLevel; }, function($sc) { return $sc->Schedule->section; }, function($sc) { return $sc->courseInfoID; }]) as $yearLevel => $sections)
        @php
            $data = true;
        @endphp
    <div class="col-md-12 mb-4">
            <div class="card">
                
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h6 class="text-sm text-primary">{{ $yearLevel }}</h6>
                    </div>
                    @foreach ($sections as $section => $courses)
                        @foreach ($courses as $courseInfoID => $subjects)
                        @php
                            $courseInfo = \App\Models\CoursesInfo::find($courseInfoID);
                        @endphp
                
                        @if ($courseInfo)
                            <h6 class="mt-3">{{ $courseInfo->Course->qualification }} | {{ $courseInfo->semester }} - <span class="fw-normal">Section {{ $section }}</span></h6>
                        @else
                            <h6 class="mt-3">Course Info Not Found</h6>
                        @endif

                            <div class="table-responsive mb-4">
                                <table id="course-data" class="table table-sm table-hover text-nowrap" style="border-bottom: 1px solid rgb(240, 240, 240)">
                                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                                        <tr>
                                            <th>#</th>
                                            <th><small>Subject Code</small></th>
                                            <th><small>Description</small></th>
                                            <th><small>Action</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $count = 0; @endphp
                                        @foreach ($subjects->sortBy('fromTime') as $sc)
                                            <tr>
                                                <td><small>{{ ++$count }}</small></td>
                                                <td><small>{{ $sc->Subjects->subjectCode }}</small></td>
                                                <td><small>{{ $sc->Subjects->description }}</small></td>
                                                <td>
                                                    <small>
                                                        <a wire:navigate href="{{ route('trainer.students', ['id' => $aes->encrypt($sc->id), 'scheduleID' => $aes->encrypt($sc->scheduleID), 'courseInfoID' => $aes->encrypt($sc->courseInfoID), 'subjectID' => $aes->encrypt($sc->subject)]) }}" class="btn btn-xs btn-primary me-1"><iconify-icon icon="lets-icons:view-duotone" width="18" height="18" class="me-1"></iconify-icon> View</a>
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($count == 0)
                                            <tr>
                                                <td colspan="7" class="text-center"><small>No Data Found</small></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    @if($data == false)
        <div class="card">
            <div class="card-body text-center"><small>No Data Found (Search to display data)</small></div>
        </div>
    @endif
</div>