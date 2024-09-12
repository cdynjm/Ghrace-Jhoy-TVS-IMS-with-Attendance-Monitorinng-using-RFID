<table id="schedule-course-data" class="table table-sm table-hover" style="border-bottom: 1px solid rgb(240, 240, 240)">
    <thead class="text-dark" style="background: rgb(244, 244, 244)">
        <tr>
            <th>#</th>
            <th><small>Sector</small></th>
            <th><small>Qualification</small></th>
            <th><small>Status</small></th>
            <th><small>COPR #</small></th>
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
                <td><a wire:navigate href="{{ route(Auth::user()->role == 1 ? 'admin.create-schedule' : 'registrar.create-schedule', ['id' => $aes->encrypt($cor->id)]) }}"><small>{{ $cor->qualification }}</small></a></td>
                <td><small>{{ $cor->status }}</small></td>
                <td><small>{{ $cor->copr }}</small></td>
            </tr>
            
        @endforeach
        @if($count == 0)
            <tr>
                <td colspan="6" class="text-center"><small>No Data Found</small></td>
            </tr>
        @endif
    </tbody>
</table>