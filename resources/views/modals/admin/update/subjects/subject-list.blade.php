<div class="edit-subject-list-data">
    @if(!empty($subjects))
    @foreach ($subjects as $key => $sub)
    <div id="subject-wrapper" class="mb-4">
        <div class="subject-group mb-2">
            <label for="" style="font-size: 12px;">Subject Schedule</label>
            <input type="text" class="form-control mb-2 fw-bold" value="{{ $sub->Subjects->description }}" readonly>
            <input type="hidden" value="{{ $aes->encrypt($sub->id) }}" name="subjectID[]">
            @php
                $label = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                $days = [$sub->mon, $sub->tue, $sub->wed, $sub->thu, $sub->fri, $sub->sat];
            @endphp

            <div class="mb-2">
                @foreach($days as $i => $day)
                <div class="form-check form-switch d-inline-flex align-items-center me-2">
                    <input type="checkbox" class="form-check-input" name="days[{{ $key }}][{{ $i }}]" value="1" @checked($day)>
                    <label class="form-check-label ms-1" for="" style="font-size: 12px" class="me-2">{{ $label[$i] }}</label>
                </div>
                @endforeach
            </div>

            <label for="" style="font-size: 12px">Time - FROM | TO</label>
            <div class="d-flex">
                <input type="time" name="fromTime[]" value="{{ $sub->fromTime }}" class="form-control mb-2 me-2" required>
                <input type="time" name="toTime[]" value="{{ $sub->toTime }}" class="form-control mb-2" required>
            </div>

            <label for="" style="font-size: 12px;">Instructor</label>
            <select name="instructor[]" id="" class="form-select me-2 mb-2" required>
                <option value="">Select...</option>
                @foreach ($instructors as $in)
                    <option value="{{ $aes->encrypt($in->id) }}" @selected($sub->instructor == $in->id)>{{ $in->instructor }}</option>
                @endforeach
            </select>

            <label for="" style="font-size: 12px;">Room/Location</label>
            <input type="text" name="room[]" class="form-control" value="{{ $sub->room }}" required>
            
        </div>
    </div>
    @endforeach
    @endif
</div>