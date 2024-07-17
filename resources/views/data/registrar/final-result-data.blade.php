<table id="final-result-data" class="table table-sm table-hover" style="border-bottom: 1px solid rgb(240, 240, 240)">
    <thead class="text-dark" style="background: rgb(244, 244, 244)">
        <tr>
            <th class="text-nowrap">#</th>
            <th class="text-nowrap"><small>Applicant Name</small></th>
            <th class="text-nowrap"><small>Address</small></th>
            <th class="text-nowrap"><small>Registration</small></th>
            <th class="text-nowrap"><small>Exam</small></th>
            <th class="text-nowrap"><small>Interview</small></th>
            <th class="text-nowrap"><small>Qualification</small></th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 0
        @endphp
        
        @foreach ($learnersProfile as $lp)
            @php
                $count += 1;
            @endphp
            <tr>
                <td class="text-nowrap"><small><input type="checkbox" class="childCheckbox-final me-2" name="applicant[]" value="{{ $aes->encrypt2($lp->id) }}"> {{ $count }}</small></td>
                <td class="text-nowrap"><small>{{ $lp->lastname }}, {{ $lp->firstname }} {{ $lp->middlename }}</small></td>
                <td class="text-nowrap"><small>{{ $lp->Barangay->brgyDesc }}, {{ ucwords(strtolower($lp->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($lp->Province->provDesc)) }} - {{ $lp->Region->regDesc }}</small></td>
                <td class="text-nowrap"><small>{{ date('M d, Y', strtotime($lp->created_at)) }}</small></td>
                <td class="text-nowrap"><small>{{ date('M d, Y', strtotime($lp->exam)) }}</small></td>
                <td class="text-nowrap"><small>{{ date('M d, Y', strtotime($lp->interview)) }}</small></td>
                <td class="text-nowrap"><small>{{ $learnersCourse->where('studentID', $lp->id)->first()->Course->qualification }}</small></td>
            </tr>
        @endforeach

        @if($count == 0)
            <tr>
                <td colspan="10" class="text-center"><small>No Data Found</small></td>
            </tr>
        @endif
    </tbody>
</table>