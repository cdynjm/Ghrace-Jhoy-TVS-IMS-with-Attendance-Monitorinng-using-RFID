<div id="view-graduates-data">
    
    
       
            <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
                <thead class="text-dark" style="background: rgb(244, 244, 244)">
                    <tr>
                        <th class="text-nowrap">#</th>
                        <th class="text-nowrap"><small>Student Name</small></th>
                        <th class="text-nowrap"><small>Address</small></th>
                        <th class="text-nowrap"><small>Date Graduated</small></th>
                        <th class="text-nowrap"><small>Employment Status</small></th>
                        <th class="text-nowrap"><small>Company/Establishment</small></th>
                        <th class="text-nowrap"><small>Date Employed</small></th>
                        <th class="text-nowrap"><small>Action</small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($graduates as $index => $gr)
                        <tr>
                            <td
                            id="{{ $aes->encrypt($gr->id) }}"
                            company="{{ $gr->company }}"
                            dateHired="{{ $gr->dateHired }}"
                            employmentStatus="{{ $gr->graduateEmploymentStatus }}"
                            courseID="{{ $aes->encrypt($course->id) }}"
                            ><small>{{ $index + 1 }}</small></td>
                            <td><small>{{ $gr->lastname }}, {{ $gr->firstname }}, {{ $gr->middlename }}</small></td>
                            <td><small>{{ $gr->Barangay->brgyDesc }}, {{ ucwords(strtolower($gr->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($gr->Province->provDesc)) }} - {{ $gr->Region->regDesc }}</small></td>
                            <td><small>{{ $gr->dateGraduated ? date('M d, Y', strtotime($gr->dateGraduated)) : '-' }}</small></td>
                            <td>
                                @if($gr->graduateEmploymentStatus == 0)
                                    <small class="text-danger">Unemployed</small>
                                @else
                                    <small class="text-success">Employed</small>
                                @endif
                            </td>
                            <td><small>{{ $gr->company ? $gr->company : '-' }}</small></td>
                            <td><small>{{ $gr->dateHired ? date('M d, Y', strtotime($gr->dateHired)) : '-' }}</small></td>
                            <td>
                                <small>
                                    <a href="javascript:;" class="mt-3" id="edit-employment-status">
                                        <iconify-icon icon="fluent:edit-48-filled" width="20" height="20"></iconify-icon>
                                    </a>

                                    <a href="/messenger/{{ $gr->User->id }}" class=" ms-2"><iconify-icon icon="solar:chat-dots-bold-duotone" width="20" height="20" class="me-1"></iconify-icon></a>
                                </small>
                            </td>                    
                        </tr>
                        @endforeach   
                </tbody>
            </table>
      
</div>
