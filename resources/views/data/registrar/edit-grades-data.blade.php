<div id="edit-grades-data">
    @php
    $data = false;

    $latestYearLevel = $yearLevel->sortByDesc(function($yl) {
            return [$yl->Schedule->schoolYear, $yl->Schedule->CourseInfo->semester];
        })->first();
    @endphp

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
                            <th class="text-nowrap"><small>Assessment</small></th>
                            <th class="text-nowrap"><small>Action</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalUnits = 0;
                            $totalAvg = 0;
                            $count = 0;
                            $mtValues = [];
                            $ftValues = [];
                            $avgValues = [];
                            $subjectCodes = [];
                        @endphp
                        @foreach ($studentGrading->where('studentYearLevelID', $yl->id) as $sub)
                        <tr>
                            <td
                            id="{{ $aes->encrypt($student->id) }}"
                            gradeID="{{ $aes->encrypt($sub->id) }}"
                            identifier="{{ $sub->id }}"
                            mt="{{ $sub->mt }}"
                            ft="{{ $sub->ft }}"
                            nc="{{ $sub->Subjects->NC }}"
                            assessment="{{ $sub->assessment }}"
                            ><small>{{ $sub->Subjects->subjectCode }}</small></td>
                            <td><small>{{ $sub->Subjects->description }}</small></td>
                            <td><small>{{ $sub->Subjects->units }}</small></td>
                            <td><small>{{ $sub->Instructors->instructor }}</small></td>
                            <td class="grade-cell" data-type="mt">
                                <div class="grade-content">
                                    <small>{{ $sub->mt }}</small>
                                </div>
                                <div class="grade-input" style="display: none;">
                                    <small class="text-danger mt-invalid" style="display: none;">Invalid Grade</small>
                                    <input type="number" id="mt-grades-{{ $sub->id }}" class="form-control mt-grades-invalid" value="{{ $sub->mt }}">
                                </div>
                            </td>
                            <td class="grade-cell" data-type="ft">
                                <div class="grade-content">
                                    <small>{{ $sub->ft }}</small>
                                </div>
                                <div class="grade-input" style="display: none;">
                                    <small class="text-danger ft-invalid" style="display: none;">Invalid Grade</small>
                                    <input type="number" id="ft-grades-{{ $sub->id }}" class="form-control ft-grades-invalid" value="{{ $sub->ft }}">
                                </div>
                            </td>
                            <td>
                                <div>
                                    <small class="fw-bold">
                                        {{ $sub->avg }}
                                    </small>
                                </div>
                            </td>
                            <td data-type="nc">
                                <small class="resultant-content">
                                    @if($sub->Subjects->NC == 0)
                                        <span style="font-size: 12px">None</span>
                                    @else
                                        @if($sub->assessment == 0)
                                            <i class="fa-solid fa-circle-check text-primary fw-bold"></i> <span class="ms-1" style="font-size: 12px">Not Yet Taken</span>
                                        @endif
                                        @if($sub->assessment == 1)
                                            <i class="fa-solid fa-circle-check text-success fw-bold"></i> <span class="ms-1" style="font-size: 12px">COMPETENT</span>
                                        @endif
                                        @if($sub->assessment == 2)
                                            <i class="fa-solid fa-circle-xmark text-danger fw-bold"></i> <span class="ms-1" style="font-size: 12px">NOT YET COMPETENT</span>
                                        @endif
                                    @endif

                                   
                                        
                                </small>

                                <div class="resultant-subject" style="display: none">
                                    <label for="" style="font-size: 12px;">Mandatory Assessment Status</label>
                                    <select name="assessment" id="assessment-{{ $sub->id }}" class="form-select form-select-sm">
                                      <option value="0">Select...</option>
                                      <option value="1" @selected($sub->assessment == 1)>COMPETENT</option>
                                      <option value="2" @selected($sub->assessment == 2)>NOT YET COMPETENT</option>
                                    </select>
                                  </div>
                            
                            </td>
                            <td>
                                <small>
                                    @if($student->diploma == null)
                                    <a href="javascript:;" class="edit-grades-btn" data-id="{{ $sub->id }}">
                                        <i class="fas fa-marker"></i>
                                    </a>
                                    <a href="javascript:;" class="save-grades-btn me-2" id="update-grades" data-id="{{ $sub->id }}" style="display: none;">
                                        <i class="fas fa-save"></i> Save
                                    </a>
                                    <a href="javascript:;" class="cancel-grades-btn" data-id="{{ $sub->id }}" style="display: none;">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    @else
                                    -
                                    @endif
                                </small>
                            </td>
                        </tr>
                        @php
                            $totalUnits += $sub->Subjects->units;
                            if ($sub->avg != 0) {
                                $totalAvg += $sub->avg;
                                $count++;
                            }
                            $mtValues[] = $sub->mt;
                            $ftValues[] = $sub->ft;
                            $avgValues[] = $sub->avg;
                            $subjectCodes[] = $sub->Subjects->subjectCode;
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

<style>



.grade-input input {
    width: 90%;        /* Allow input width to adjust based on its content */
    min-width: 50px;   /* Set a minimum width to prevent it from shrinking too much */
    max-width: 70%;     /* Limit the maximum width to avoid overflowing */
    /* Center the input horizontally if there's extra space */
    display: block;     /* Ensure the input is on its own line */
    padding: 5px;       /* Add padding for better usability */
    box-sizing: border-box; /* Include padding in width calculation */
}

</style>