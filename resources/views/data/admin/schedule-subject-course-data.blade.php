<table id="schedule-subject-course-data" class="table table-sm table-hover" style="border-bottom: 1px solid rgb(240, 240, 240)">
    <thead class="text-dark" style="background: rgb(244, 244, 244)">
        <tr>
            <th>#</th>
            <th><small>Year</small></th>
            <th><small>Semester</small></th>
            <th><small>Section</small></th>
            <th><small>Subjects</small></th>
            <th><small>Action</small></th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 0
        @endphp
        @foreach ($schedule as $sc)
            @php
                $count += 1
            @endphp
            <tr>
                <td
                
                id="{{ $aes->encrypt($sc->id) }}"
                courseID="{{ $aes->encrypt($sc->courseID) }}"
                yearLevel="{{ $aes->encrypt($sc->courseInfoID) }}"
                section="{{ $sc->section }}"
                slots="{{ $sc->slots }}"

                >
                    <small>{{ $count }}</small>
                </td>
                <td>
                    <small>{{ $sc->CourseInfo->yearLevel }}</small>
                </td>
                <td>
                    <small>{{ $sc->CourseInfo->semester }}</small>
                </td>
                <td><small>{{ $sc->section }}</small></td>
                <td>
                    <table class="text-nowrap table table-sm">
                        <tr>
                            <th><small>Subject</small></th>
                            <th><small>Schedule</small></th>
                            <th><small>Instructor</small></th>
                        </tr>
                        @foreach ($subjectSchedule->where('scheduleID', $sc->id) as $sub)
                           <tr style="border-bottom: transparent">
                                <td>
                                    <div><small>{{ $sub->Subjects->description }}</small></div>
                                </td>
                                <td>
                                    <div>
                                    <small>
                                        
                                        @if($sub->mon == 1)
                                            Mon 
                                        @endif

                                        @if($sub->tue == 1)
                                            Tue 
                                        @endif

                                        @if($sub->wed == 1)
                                            Wed 
                                        @endif

                                        @if($sub->thu == 1)
                                            Thu 
                                        @endif

                                        @if($sub->fri == 1)
                                            Fri 
                                        @endif

                                        @if($sub->sat == 1)
                                            Sat 
                                        @endif
                                        |
                                        {{ date('h:i A', strtotime($sub->fromTime)) }} - {{ date('h:i A', strtotime($sub->toTime)) }} | {{ $sub->room }}

                                    </small>
                                    </div>
                                </td>
                                <td>
                                    <div><small>{{ $sub->Instructors->instructor }}</small></div>
                                </td>
                                
                           </tr>
                        @endforeach
                    </table>
                </td>
                <td>
                    <small>
                        <a href="javascript:;" id="edit-schedule" class="me-2">
                            <i class="fas fa-marker"></i>
                        </a>
                        <a href="javascript:;" id="delete-course">
                            <i class="fas fa-trash" class="me-2"></i>
                        </a>
                    </small>
                </td>
            </tr>

        @endforeach
        @if($count == 0)
            <tr>
                <td colspan="6" class="text-center"><small>No Data Found</small></td>
            </tr>
        @endif
    </tbody>
</table>