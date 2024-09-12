<table id="instructors-data" class="table table-sm table-hover text-nowrap" style="border-bottom: 1px solid rgb(240, 240, 240)">
    <thead class="text-dark" style="background: rgb(244, 244, 244)">
        <tr>
            <th>#</th>
            <th><small>Instructor</small></th>
            <th><small>Address</small></th>
            <th><small>Contact Number</small></th>
            <th><small>Degree</small></th>
            @if(Auth::user()->role == 2)
            <th><small>Action</small></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @php
            $count = 0
        @endphp
        @foreach ($instructors as $in)
            @php
                $count += 1
            @endphp
            <tr>
                <td
                
                id="{{ $aes->encrypt($in->id) }}"
                instructor="{{ $in->instructor }}"
                address="{{ $in->address }}"
                contactNumber="{{ $in->contactNumber }}"
                degree="{{ $in->degree }}"
                email="{{ $in->User->email }}"

                ><small>{{ $count }}</small></td>
                <td><small>{{ $in->instructor }}</small></td>
                <td><small>{{ $in->address }}</small></td>
                <td><small>{{ $in->contactNumber }}</small></td>
                <td><small>{{ $in->degree }}</small></td>
                @if(Auth::user()->role == 2)
                <td>
                    <small>
                        <a href="javascript:;" id="edit-instructor" class="me-2">
                            <i class="fas fa-marker"></i>
                        </a>
                        <a href="javascript:;" id="delete-instructor">
                            <i class="fas fa-trash" class="me-2"></i>
                        </a>
                    </small>
                </td>
                @endif
            </tr>
        @endforeach
        @if($count == 0)
            <tr>
                <td colspan="6" class="text-center"><small>No Data Found</small></td>
            </tr>
        @endif
    </tbody>
</table>