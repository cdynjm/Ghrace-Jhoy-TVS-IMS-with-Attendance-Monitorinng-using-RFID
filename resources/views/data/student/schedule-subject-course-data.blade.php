<div id="schedule-subject-course-data">
    @php
        $data = false;
    @endphp
                @if(Auth::user()->Student->freshmen == 0)
                @foreach ($yearLevel as $yl)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h6>AY: {{ $yl->Schedule->schoolYear }}</h6>
                                    <h6 class="text-sm">{{ $yl->Schedule->CourseInfo->yearLevel }} - {{ $yl->Schedule->CourseInfo->semester }}</h6>
                                    <p class="my-1">Section: {{ $yl->Schedule->section }}</p>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-sm" id="download-ORF" data-id="{{ $aes->encrypt($yl->scheduleID) }}" data-name="{{ Auth::user()->Student->firstname }} {{ Auth::user()->Student->lastname }}"><iconify-icon icon="fluent:document-copy-20-filled" width="18" class="me-2"></iconify-icon> <small>Download ORF</small></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
                                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                                        <tr>
                                            <th class="text-nowrap"><small>Subject Code</small></th>
                                            <th class="text-nowrap"><small>Description</small></th>
                                            <th class="text-nowrap"><small>Units</small></th>
                                            <th class="text-nowrap"><small>Schedule</small></th>
                                            <th class="text-nowrap"><small>Instructor</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalUnits = 0;
                                        @endphp
                                        @foreach ($subjectSchedule->where('scheduleID', $yl->scheduleID) as $sub)
                                        <tr>
                                            <td><small>{{ $sub->Subjects->subjectCode }}</small></td>
                                            <td><small>{{ $sub->Subjects->description }}</small></td>
                                            <td><small>{{ $sub->Subjects->units }}</small></td>
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
                                                        {{ $sub->fromTime != null ? date('h:i A', strtotime($sub->fromTime)) : 'none' }} - {{ $sub->toTime != null ? date('h:i A', strtotime($sub->toTime)) : 'none' }} | {{ $sub->room }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div><small>{{ $sub->Instructors->instructor }}</small></div>
                                            </td>
                                        </tr>
                                        @php
                                            $totalUnits += $sub->Subjects->units;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-end"><small><strong>Total Units:</strong></small></td>
                                            <td><small><strong>{{ $totalUnits }}</strong></small></td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $data = true;
                @endphp
                @endforeach
                @endif

                @if($data == false)
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <p class="my-0">No Available Schedule</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
</div>