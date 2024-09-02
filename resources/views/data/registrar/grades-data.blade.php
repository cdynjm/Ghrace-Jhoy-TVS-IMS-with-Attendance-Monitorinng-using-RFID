<div id="grades-data">
    @foreach ($enrollees as $yearLevel => $enrolleesInfo)
        
        <p class="fw-bold">Year Level: {{ $yearLevel }}</p>
        
        
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
                    
                    @foreach ($enrolleesInfo as $index => $en)
                        <tr>
                            <td
                            id="{{ $aes->encrypt($en->id) }}"
                            courseID="{{ $aes->encrypt2($en->LearnersCourse->course) }}"
                            ><small>{{ $index + 1 }}</small></td>
                            <td><small>{{ $en->lastname }}, {{ $en->firstname }}, {{ $en->middlename }}</small></td>
                            <td><small>{{ $en->Barangay->brgyDesc }}, {{ ucwords(strtolower($en->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($en->Province->provDesc)) }} - {{ $en->Region->regDesc }}</small></td>
                            <td>
                                <small>
                                    <a wire:navigate class="btn btn-sm btn-primary" href="{{ route('registrar.edit-grades', ['id' => $aes->encrypt($en->id)]) }}">
                                        <iconify-icon icon="lets-icons:view-duotone" width="18" height="18" class="me-1"></iconify-icon> View
                                    </a>
                                </small>
                            </td>                    
                        </tr>
                    @endforeach
                </tbody>
            </table>
       
    @endforeach          
</div>
