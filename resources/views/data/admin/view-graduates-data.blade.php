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
            @php
            $count = 0
        @endphp
            @foreach ($graduates as $index => $gr)
            @php
            $count += 1
        @endphp
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
                           

                            <a href="/messenger/{{ $gr->User->id }}" class=" ms-2"><iconify-icon icon="solar:chat-dots-bold-duotone" width="20" height="20" class="me-1"></iconify-icon></a>
                            <a wire:navigate class="" href="{{ route('admin.edit-grades', ['id' => $aes->encrypt($gr->id)]) }}">
                                <iconify-icon icon="lets-icons:view-duotone" width="20" height="20" class="me-1"></iconify-icon>
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

</div>
