
   
    <table class="table table-sm table-hover text-nowrap" id="grades-data-table"  style="border-bottom: 1px solid rgb(240, 240, 240)">
        <thead class="text-dark" style="background: rgb(244, 244, 244)">
            <tr>
                <th>#</th>
                <th><small>Student</small></th>
                <th><small>Midterm</small></th>
                <th><small>Final Term</small></th>
                <th><small>Average</small></th>
                <th><small>Assessment</small></th>
                <th><small>Action</small></th>
                
            </tr>
        </thead>
        <tbody>
            @php
                $count = 0
            @endphp
            @if(!empty($grades->first()->Subjects->description))
            <tr class="exclude-from-search">
                <td colspan="7" class="text-start fw-bold">{{ $grades->first()->Subjects->description }}</td>
            </tr>
            @endif
            @foreach ($students as $stu)
                @php
                    $count += 1
                @endphp
                <tr>
                    <td
                    id="{{ $aes->encrypt($stu->studentID) }}"
                    gradeID="{{ $aes->encrypt($grades->where('studentYearLevelID', $stu->id)->first()->id) }}"
                    identifier="{{ $grades->where('studentYearLevelID', $stu->id)->first()->id }}"
                    schoolYear="{{ $stu->Schedule->schoolYear }}"
                    semester="{{ $aes->encrypt($stu->Schedule->courseInfoID) }}"
                    subject="{{ $aes->encrypt($grades->where('studentYearLevelID', $stu->id)->first()->subjectID) }}"
                    section="{{ $aes->encrypt($stu->Schedule->id) }}"
                    
                    mt={{ $grades->where('studentYearLevelID', $stu->id)->first()->mt }}
                    ft={{ $grades->where('studentYearLevelID', $stu->id)->first()->ft }}
                    nc={{ $grades->where('studentYearLevelID', $stu->id)->first()->Subjects->NC }}
                    assessment={{ $grades->where('studentYearLevelID', $stu->id)->first()->assessment }}

                    >{{ $count }}</td>
                    <td><small>{{ $stu->Student->lastname }} {{ $stu->Student->firstname }} {{ $stu->Student->middlename }}</small></td>
                    <td class="grade-cell" data-type="mt">
                        <div class="grade-content">
                            <small>{{ $grades->where('studentYearLevelID', $stu->id)->first()->mt }}</small>
                        </div>
                        <div class="grade-input" style="display: none;">
                            <small class="text-danger mt-invalid" style="display: none;">Invalid Grade</small>
                            <input type="number" id="mt-grades-{{ $grades->where('studentYearLevelID', $stu->id)->first()->id }}" class="form-control mt-grades-invalid" value="{{ $grades->where('studentYearLevelID', $stu->id)->first()->mt }}">
                        </div>
                    </td>
                    <td class="grade-cell" data-type="ft">
                        <div class="grade-content">
                            <small>{{ $grades->where('studentYearLevelID', $stu->id)->first()->ft }}</small>
                        </div>

                        <div class="grade-input" style="display: none;">
                            <small class="text-danger ft-invalid" style="display: none;">Invalid Grade</small>
                            <input type="number" id="ft-grades-{{ $grades->where('studentYearLevelID', $stu->id)->first()->id }}" class="form-control ft-grades-invalid" value="{{ $grades->where('studentYearLevelID', $stu->id)->first()->ft }}">
                        </div>
                    </td>
                    <td><small class="fw-bold">{{ $grades->where('studentYearLevelID', $stu->id)->first()->avg }}</small></td>
                    <td data-type="nc">
                        <small class="resultant-content">
                            @if($grades->where('studentYearLevelID', $stu->id)->first()->Subjects->NC == 0)
                                <span style="font-size: 12px">None</span>
                            @else
                                @if($grades->where('studentYearLevelID', $stu->id)->first()->assessment == 0)
                                    <i class="fa-solid fa-circle-check text-primary fw-bold"></i> <span class="ms-1" style="font-size: 12px">Not Yet Taken</span>
                                @endif
                                @if($grades->where('studentYearLevelID', $stu->id)->first()->assessment == 1)
                                    <i class="fa-solid fa-circle-check text-success fw-bold"></i> <span class="ms-1" style="font-size: 12px">COMPETENT</span>
                                @endif
                                @if($grades->where('studentYearLevelID', $stu->id)->first()->assessment == 2)
                                    <i class="fa-solid fa-circle-xmark text-danger fw-bold"></i> <span class="ms-1" style="font-size: 12px">NOT YET COMPETENT</span>
                                @endif
                            @endif
                        </small>

                        <div class="resultant-subject" style="display: none">
                            <label for="" style="font-size: 12px;">Mandatory Assessment Status</label>
                            <select name="assessment" id="assessment-{{ $grades->where('studentYearLevelID', $stu->id)->first()->id }}" class="form-select form-select-sm">
                              <option value="0">Select...</option>
                              <option value="1" @selected($grades->where('studentYearLevelID', $stu->id)->first()->assessment == 1)>COMPETENT</option>
                              <option value="2" @selected($grades->where('studentYearLevelID', $stu->id)->first()->assessment == 2)>NOT YET COMPETENT</option>
                            </select>
                          </div>
                    </td>
                    <td class="text-start" width="15%">
                        
                        <a wire:navigate class=" me-1 view-grades-btn-value" href="{{ route('registrar.edit-grades', ['id' => $aes->encrypt($stu->studentID), 'courseID' => $aes->encrypt($stu->Schedule->courseID)]) }}">
                            <iconify-icon icon="solar:eye-bold-duotone" width="20" height="20" class="me-1"></iconify-icon> 
                        </a>
                        
                        <a class="me-1 edit-grades-btn-value" href="javascript:;" id="" data-id="{{ $grades->where('studentYearLevelID', $stu->id)->first()->id }}">
                            <iconify-icon icon="lets-icons:edit-duotone" width="20" height="20" class="me-1"></iconify-icon>
                        </a>

                        <small>
                            <a href="javascript:;" class="save-grades-btn-value me-2" id="update-grades-data-value" data-id="{{ $grades->where('studentYearLevelID', $stu->id)->first()->id }}"  style="display: none;">
                                <i class="fas fa-save"></i> Save
                            </a>
                            <a href="javascript:;" class="cancel-grades-btn-value" data-id="{{ $grades->where('studentYearLevelID', $stu->id)->first()->id }}"  style="display: none;">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </small>
                    </td>
                </tr>
                
            @endforeach
        </tbody>
    </table>

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