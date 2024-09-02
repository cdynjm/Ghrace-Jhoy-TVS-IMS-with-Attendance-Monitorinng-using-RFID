<table id="unscheduled-data" class="table table-sm table-hover" style="border-bottom: 1px solid rgb(240, 240, 240)">
    <thead class="text-dark" style="background: rgb(244, 244, 244)">
        <tr>
            <th class="text-nowrap">#</th>
            <th class="text-nowrap"><small>Applicant Name</small></th>
            <th class="text-nowrap"><small>Address</small></th>
            <th class="text-nowrap"><small>Registration Date</small></th>
            <th class="text-nowrap"><small>Qualification</small></th>
            <th class="text-nowrap"><small>Action</small></th>
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
                <td class="text-nowrap"><small><input type="checkbox" class="childCheckbox me-2" name="applicant[]" value="{{ $aes->encrypt2($lp->id) }}"> {{ $count }}</small></td>
                <td class="text-nowrap"><small>{{ $lp->lastname }}, {{ $lp->firstname }} {{ $lp->middlename }}</small></td>
                <td class="text-nowrap"><small>{{ $lp->Barangay->brgyDesc }}, {{ ucwords(strtolower($lp->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($lp->Province->provDesc)) }} - {{ $lp->Region->regDesc }}</small></td>
                <td class="text-nowrap"><small>{{ date('M d, Y', strtotime($lp->created_at)) }}</small></td>
                <td class="text-nowrap"><small>{{ $learnersCourse->where('studentID', $lp->id)->first()->Course->qualification }}</small></td>
                <td class="text-nowrap">
                    <small>
                        <a href="javascript:;" id="download-forms" title="Download Information" class="me-2" 
                            data-registration-id="{{ $aes->encrypt2($lp->id) }}" 
                            data-psa="{{ $psa->where('studentID', $lp->id)->first()->filename }}"
                            data-form137="{{ $form137->where('studentID', $lp->id)->first()->filename }}"
                            data-name="{{ $lp->firstname }}-{{ $lp->lastname }}">
                            <i class="fas fa-download"></i> Forms
                        </a>
                        <!-- <a href="javascript:;" class="text-danger" title="Decline"><i class="fas fa-times"></i></a> -->
                    </small>
                </td>
            </tr>
        @endforeach

        @if($count == 0)
            <tr>
                <td colspan="10" class="text-center"><small>No Data Found</small></td>
            </tr>
        @endif
    </tbody>
</table>