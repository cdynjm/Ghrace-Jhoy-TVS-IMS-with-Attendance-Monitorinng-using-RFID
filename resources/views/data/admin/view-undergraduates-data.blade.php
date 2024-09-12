<div id="view-undergraduates-data">
    
    @php
        $yearLevelNames = [
            1 => '1st Years',
            2 => '2nd Years',
            3 => '3rd Years',
            4 => '4th Years',
        ];
    @endphp
    

    @foreach ($undergraduates as $yearLevel => $under)
        
        <p class="fw-bold">{{ $yearLevelNames[$yearLevel] ?? $yearLevel . 'th Years' }}</p>

    <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
        <thead class="text-dark" style="background: rgb(244, 244, 244)">
            <tr>
                <th class="text-nowrap">#</th>
                <th class="text-nowrap"><small>Student Name</small></th>
                <th class="text-nowrap"><small>Address</small></th>
                <th class="text-nowrap"><small>RFID Card Number</small></th>
                <th class="text-nowrap"><small>ULI</small></th>
                <th class="text-nowrap"><small>Action</small></th>
            </tr>
        </thead>
        <tbody>
            @php
            $count = 0
        @endphp
            @foreach ($under as $index => $gr)
            @php
            $count += 1
        @endphp
                <tr>
                    <td
                    id="{{ $aes->encrypt($gr->id) }}"
                    RFID="{{ $gr->RFID }}"
                    ULI="{{ $gr->ULI }}"
                    courseID="{{ $aes->encrypt($course->id) }}"
                    ><small>{{ $index + 1 }}</small></td>
                    <td><small>{{ $gr->lastname }}, {{ $gr->firstname }}, {{ $gr->middlename }}</small></td>
                    <td><small>{{ $gr->Barangay->brgyDesc }}, {{ ucwords(strtolower($gr->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($gr->Province->provDesc)) }} - {{ $gr->Region->regDesc }}</small></td>
                    
                    <td><small>{{ $gr->RFID ? $gr->RFID : '-' }}</small></td>
                    <td><small>{{ $gr->ULI ? $gr->ULI : '-' }}</small></td>
                    <td>
                        <small class="d-flex justif-content-center aligh-items-center">
                            <a class="btn btn-sm btn-secondary" wire:navigate href="{{ route('admin.edit-grades', ['id' => $aes->encrypt($gr->id)]) }}">
                                <iconify-icon icon="solar:chart-bold-duotone" width="18" height="18" class="me-1"></iconify-icon> Grades
                            </a>
                            <a class="btn btn-sm btn-primary ms-2" href="/messenger/{{ $gr->User->id }}" class=" ms-2"><iconify-icon icon="solar:chat-dots-bold-duotone" width="20" height="20" class=""></iconify-icon></a>
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
@endforeach
</div>
