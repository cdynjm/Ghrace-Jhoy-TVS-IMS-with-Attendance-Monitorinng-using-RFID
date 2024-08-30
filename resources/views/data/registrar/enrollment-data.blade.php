<div id="enrollment-data">
    @foreach ($enrollees as $yearLevel => $enrolleesInfo)
        @php
            $count = 0
        @endphp
    <p class="fw-bold">Year Level: {{ $yearLevel }}</p>
    <table class="table table-sm table-hover text-nowrap" style="border-bottom: 1px solid rgb(240, 240, 240)">
        <thead class="text-dark" style="background: rgb(244, 244, 244)">
            <tr>
                <th class="text-nowrap">#</th>
                <th class="text-nowrap"><small>Student Name</small></th>
                <th class="text-nowrap"><small>Address</small></th>
                <th class="text-nowrap"><small>Action</small></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($enrolleesInfo as $en)
                @php
                    $count += 1
                @endphp
                @if($en->semester == 1)
                    <tr class="">
                        <td colspan="10" class="fw-bold text-primary">1st Semester</td>
                    </tr>
                    <tr>
                        <td><small>{{ $count }}</small></td>
                        <td><small>{{ $en->lastname }}, {{ $en->firstname }}, {{ $en->middlename }}</small></td>
                        <td><small>{{ $en->Barangay->brgyDesc }}, {{ ucwords(strtolower($en->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($en->Province->provDesc)) }} - {{ $en->Region->regDesc }}</small></td>
                        <td><small><button class="btn btn-sm btn-success">Enroll</button></small></td>
                    </tr>
                @endif
                @if($en->semester == 2)
                    <tr class="">
                        <td colspan="10" class="fw-bold text-primary">2nd Semester</td>
                    </tr>
                    <tr>
                        <td><small>{{ $count }}</small></td>
                        <td><small>{{ $en->lastname }}, {{ $en->firstname }}, {{ $en->middlename }}</small></td>
                        <td><small>{{ $en->Barangay->brgyDesc }}, {{ ucwords(strtolower($en->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($en->Province->provDesc)) }} - {{ $en->Region->regDesc }}</small></td>
                        <td><small><button class="btn btn-sm btn-success">Enroll</button></small></td>
                    </tr>
                @endif
            @endforeach
            @if($count == 0)
                <tr>
                    <td colspan="10" class="text-center"><small>No Data Found</small></td>
                </tr>
            @endif
        </tbody>
    </table>

    @endforeach
            
</div>
</div>
    