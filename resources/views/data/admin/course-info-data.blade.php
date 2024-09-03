<table id="course-info-data" class="table table-sm table-hover" style="border-bottom: 1px solid rgb(240, 240, 240)">
    <thead class="text-dark" style="background: rgb(244, 244, 244)">
        <tr>
            <th>#</th>
            <th><small>Year</small></th>
            <th><small>Semester</small></th>
            <th><small>Subjects</small></th>
            <th><small>Action</small></th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 0
        @endphp
        @foreach ($courseInfo as $ci)
            @php
                $count += 1
            @endphp
            <tr>
                <td
                courseInfoID="{{ $aes->encrypt($ci->id) }}"
                yearLevel="{{ $ci->yearLevel }}"
                semester="{{ $ci->semester }}"
                >
                    <small>{{ $count }}</small>
                </td>
                <td>
                    <small>{{ $ci->yearLevel }}</small>
                </td>
                <td>
                    <small>{{ $ci->semester }}</small>
                </td>
                <td>
                    <table class="text-nowrap table table-sm">
                        <tr>
                            <th><small>Subject Code</small></th>
                            <th><small>Description</small></th>
                            <th><small>Units</small></th>
                            <th><small>Resultant Sub/NC II</small></th>
                        </tr>
                        @php
                            $totalUnits = 0;
                        @endphp
                        @foreach ($subjects->where('courseInfoID', $ci->id) as $sub)
                           <tr style="border-bottom: transparent">
                                <td>
                                    <div><small>{{ $sub->subjectCode }}</small></div>
                                </td>
                                <td>
                                    <div><small>{{ $sub->description }}</small></div>
                                </td>
                                <td>
                                    <div><small>{{ $sub->units }}</small></div>
                                </td>
                                <td>
                                    @if($sub->NC == 1)
                                        <small class="fw-bold text-primary">YES</small>
                                    @endif
                                </td>
                           </tr>
                           @php
                                $totalUnits += $sub->units;
                            @endphp
                        @endforeach
                        <tr style="border-bottom: transparent">
                            <td colspan="2" class="text-end"><small><strong>Total Units:</strong></small></td>
                            <td><small><strong>{{ $totalUnits }}</strong></small></td>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <a href="javascript:;" id="edit-course-info" class="me-2" data-id="{{ $aes->encrypt($course->id) }}">
                        <i class="fas fa-marker"></i>
                    </a>
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