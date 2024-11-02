
   
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
                    <td><small>{{ $grades->where('studentYearLevelID', $stu->id)->first()->mt }}</small></td>
                    <td><small>{{ $grades->where('studentYearLevelID', $stu->id)->first()->ft }}</small></td>
                    <td><small class="fw-bold">{{ $grades->where('studentYearLevelID', $stu->id)->first()->avg }}</small></td>
                    <td>
                        <small>
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
                    </td>
                    <td class="text-start" width="15%">
                        
                        <a wire:navigate class="btn btn-sm btn-primary me-1" href="{{ route('registrar.edit-grades', ['id' => $aes->encrypt($stu->studentID), 'courseID' => $aes->encrypt($stu->Schedule->courseID)]) }}">
                            <iconify-icon icon="solar:eye-bold-duotone" width="18" height="18" class="me-1"></iconify-icon> <small>View</small>
                        </a>
                        <a class="btn btn-sm btn-primary me-1" href="javascript:;" id="update-grades-value">
                            <iconify-icon icon="lets-icons:edit-duotone" width="18" height="18" class="me-1"></iconify-icon> <small>Edit Grade</small>
                        </a>
                       
                    </td>
                </tr>
                
            @endforeach
        </tbody>
    </table>


