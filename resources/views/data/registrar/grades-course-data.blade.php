<table id="course-data" class="table table-sm table-hover text-nowrap" style="border-bottom: 1px solid rgb(240, 240, 240)">
    <thead class="text-dark" style="background: rgb(244, 244, 244)">
        <tr>
            <th>#</th>
            <th><small>Sector</small></th>
            <th><small>Qualification</small></th>
            <th><small>Status</small></th>
            <th><small>COPR #</small></th>
            <th class="text-center"><small>Action</small></th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 0
        @endphp
        @foreach ($courses as $cor)
            @php
                $count += 1
            @endphp
            <tr>
                <td
                
                id="{{ $aes->encrypt($cor->id) }}"
                sector="{{ $cor->sector }}"
                qualification="{{ $cor->qualification }}"
                status="{{ $cor->status }}"
                copr="{{ $cor->copr }}"

                ><small>{{ $count }}</small></td>
                <td><small>{{ $cor->sector }}</small></td>
                <td><small class="text-primary">{{ $cor->qualification }}</small></td>
                <td><small>{{ $cor->status }}</small></td>
                <td><small>{{ $cor->copr }}</small></td>
                <td class="text-center">
                    <div class="d-flex">
                        <a class="btn btn-sm btn-primary flex-fill" wire:navigate href="{{ route('registrar.grades', ['id' => $aes->encrypt($cor->id)]) }}">
                            <iconify-icon icon="solar:chart-bold-duotone" width="18" height="18" class="me-1"></iconify-icon> View
                        </a>
                    </div>                    
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