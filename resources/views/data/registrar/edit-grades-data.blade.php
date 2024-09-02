<div id="edit-grades-data">
    @php
        $data = false;
    @endphp
    @foreach ($yearLevel as $yl)
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h6 class="text-sm">{{ $yl->Schedule->CourseInfo->yearLevel }} - {{ $yl->Schedule->CourseInfo->semester }}</h6>
                        <p class="my-1">Section: {{ $yl->Schedule->section }}</p>
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
                                <th class="text-nowrap"><small>Instructor</small></th>
                                <th class="text-nowrap"><small>MT</small></th>
                                <th class="text-nowrap"><small>FT</small></th>
                                <th class="text-nowrap"><small>AVG</small></th>
                                <th class="text-nowrap"><small>Action</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalUnits = 0;
                                $totalAvg = 0;
                                $count = 0;
                            @endphp
                            @foreach ($studentGrading->where('studentYearLevelID', $yl->id) as $sub)
                            <tr>
                                <td
                                id="{{ $aes->encrypt($student->id) }}"
                                gradeID="{{ $aes->encrypt($sub->id) }}"
                                mt="{{ $sub->mt }}"
                                ft="{{ $sub->ft }}"
                                ><small>{{ $sub->Subjects->subjectCode }}</small></td>
                                <td><small>{{ $sub->Subjects->description }}</small></td>
                                <td><small>{{ $sub->Subjects->units }}</small></td>
                                <td><small>{{ $sub->Instructors->instructor }}</small></td>
                                <td>
                                    <div>
                                        <small class="">
                                            {{ number_format($sub->mt, 1) }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <small class="">
                                            {{ number_format($sub->ft, 1) }}
                                            </small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <small class="fw-bold">
                                            {{ number_format($sub->avg, 1) }}
                                            </small>
                                    </div>
                                </td>
                                <td>
                                    <small>
                                        <a href="javascript:;" id="edit-grades-value" class="">
                                            <i class="fas fa-marker"></i>
                                        </a>
                                    </small>
                                </td>
                            </tr>
                            @php
                                $totalUnits += $sub->Subjects->units;
                                if ($sub->avg != 0) {
                                    $totalAvg += $sub->avg;
                                    $count++;
                                }
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end"><small><strong>Total Units:</strong></small></td>
                                <td><small><strong>{{ $totalUnits }}</strong></small></td>
                                <td colspan="2" class="text-end"><small><strong>GWA:</strong></small></td>
                                <td><small><strong>{{ $count > 0 ? number_format($totalAvg / $count, 2) : '0.0' }}</strong></small></td>
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

    @if($data == false)
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <p class="my-0">No Grades Yet</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>