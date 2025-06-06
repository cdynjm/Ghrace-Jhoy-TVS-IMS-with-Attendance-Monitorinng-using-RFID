<div id="view-undergraduates-data">
    @php
        $yearLevelNames = [
            1 => '1st Years',
            2 => '2nd Years',
            3 => '3rd Years',
            4 => '4th Years',
        ];
    @endphp

    @foreach ($undergraduates as $yearLevel => $students)
        <div class="d-flex">
            <p class="fw-bold me-2">{{ $yearLevelNames[$yearLevel] ?? "{$yearLevel}th Years" }}</p> | 
            <p class="ms-2"><small>Total: </small><span class="fw-bold">{{ $students->count() }}</span></p>
        </div>
        
        <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
            <thead class="text-dark" style="background: rgb(244, 244, 244)">
                <tr>
                    <th class="text-nowrap">#</th>
                    <th class="text-nowrap"><small>Student Name</small></th>
                    <th class="text-nowrap"><small>Address</small></th>
                    <th class="text-nowrap"><small>Action</small></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $index => $gr)
                    <tr>
                        <td
                            id="{{ $aes->encrypt($gr->id) }}"
                            RFID="{{ $gr->RFID }}"
                            ULI="{{ $gr->ULI }}"
                            courseID="{{ $aes->encrypt($course->id) }}"
                        ><small>{{ $index + 1 }}</small></td>
                        <td><small>{{ $gr->lastname }}, {{ $gr->firstname }}, {{ $gr->middlename }}</small></td>
                        <td><small>{{ $gr->Barangay->brgyDesc }}, {{ ucwords(strtolower($gr->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($gr->Province->provDesc)) }} - {{ $gr->Region->regDesc }}</small></td>
                        <td>
                            <small class="d-flex">
                                <a wire:navigate class="btn btn-sm btn-primary me-1" href="{{ route('registrar.edit-grades', ['id' => $aes->encrypt($gr->id), 'courseID' => $aes->encrypt($gr->LearnersCourse->course)]) }}">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18" height="18" class="me-1"></iconify-icon> <small>View Grades</small>
                                </a>
                                <a href="/messenger/{{ $gr->User->id }}" class="ms-2">
                                    <iconify-icon icon="solar:chat-dots-bold-duotone" width="20" height="20" class="me-1"></iconify-icon>
                                </a>
                            </small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center"><small>No Data Found</small></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach
</div>
