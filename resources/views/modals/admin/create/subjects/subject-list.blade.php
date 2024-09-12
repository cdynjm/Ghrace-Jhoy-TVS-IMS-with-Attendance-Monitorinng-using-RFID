<div class="subject-list-data">
    @if(!empty($subjects))
    @foreach ($subjects as $key => $sub)
    <div id="subject-wrapper" class="mb-4">
        <div class="subject-group mb-2">
            <label for="" style="font-size: 12px;">Subject Schedule</label>
            <input type="text" class="form-control mb-2 fw-bold" value="{{ $sub->description }}" readonly>
            <input type="hidden" value="{{ $sub->id }}" name="subjectID[]">
            @php
                $label = [];

                $label[0] = 'Mon';
                $label[1] = 'Tue';
                $label[2] = 'Wed';
                $label[3] = 'Thu';
                $label[4] = 'Fri';
                $label[5] = 'Sat';
            @endphp

            <div class="mb-2">
                @for($i = 0; $i < 6; $i++)
                    <div class="form-check form-switch d-inline-flex align-items-center me-2">
                        <input type="checkbox" class="form-check-input" name="days[{{ $key }}][{{ $i }}]" value="1">
                        <label class="form-check-label ms-1" style="font-size: 12px">{{ $label[$i] }}</label>
                    </div>
                @endfor
            </div>

            <label for="" style="font-size: 12px">Time - FROM | TO</label>
            <div class="d-flex">
                <input type="time" name="fromTime[]" class="form-control mb-2 me-2" required>
                <input type="time" name="toTime[]" class="form-control mb-2" required>
            </div>

            <label for="" style="font-size: 12px;">Instructor</label>
            <select name="instructor[]" id="" class="form-select me-2 mb-2" required>
                <option value="">Select...</option>
                @foreach ($instructors as $in)
                    <option value="{{ $aes->encrypt($in->id) }}">{{ $in->instructor }}</option>
                @endforeach
            </select>

            <label for="" style="font-size: 12px;">Room/Location</label>
            <input type="text" name="room[]" class="form-control" required>
            
        </div>
    </div>
    @endforeach
    @endif
</div>