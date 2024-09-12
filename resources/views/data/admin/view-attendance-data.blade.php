<div id="view-attendance-data">
    
    @php
        $yearLevelNames = [
            1 => '1st Years',
            2 => '2nd Years',
            3 => '3rd Years',
            4 => '4th Years',
        ];
    @endphp

    @foreach ($attendance as $yearLevel => $attendanceInfo)
        
        <p class="fw-bold">{{ $yearLevelNames[$yearLevel] ?? $yearLevel . 'th Years' }}</p>
        
        
            <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
                <thead class="text-dark" style="background: rgb(244, 244, 244)">
                    <tr>
                        <th class="text-nowrap">#</th>
                        <th class="text-nowrap"><small>Student Name</small></th>
                        <th class="text-nowrap"><small>RFID Number</small></th>
                        <th class="text-nowrap"><small>Address</small></th>
                        <th class="text-nowrap"><small>Action</small></th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($attendanceInfo as $index => $en)
                        <tr>
                            <td
                            id="{{ $aes->encrypt($en->id) }}"
                            courseID="{{ $aes->encrypt2($en->LearnersCourse->course) }}"
                            ><small>{{ $index + 1 }}</small></td>
                            <td><small>{{ $en->lastname }}, {{ $en->firstname }}, {{ $en->middlename }}</small></td>
                            <td><small class="fw-bold">{{ $en->RFID }}</small></td>
                            <td><small>{{ $en->Barangay->brgyDesc }}, {{ ucwords(strtolower($en->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($en->Province->provDesc)) }} - {{ $en->Region->regDesc }}</small></td>
                            <td>
                                <small>
                                    <a wire:navigate class="btn btn-sm btn-primary" href="{{ route('admin.view-student-attendance', ['id' => $aes->encrypt($en->id)]) }}" style="font-size: 12px">
                                        <iconify-icon icon="lets-icons:view-duotone" width="18" height="18" class="me-1"></iconify-icon> View
                                    </a>
                                    <a href="/messenger/{{ $en->User->id }}" class="btn btn-sm btn-primary ms-2" style="font-size: 12px"><iconify-icon icon="solar:chat-dots-bold-duotone" width="18" height="18" class="me-1"></iconify-icon> Chat</a>
                                </small>
                            </td>                    
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @php
            $data = true;
        @endphp
    @endforeach    
    

</div>
