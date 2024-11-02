<div class="edit-subject-list-data">
    @if(!empty($subjects))
    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Subject Schedule</th>
                <th>Days</th>
                <th>Time (FROM | TO)</th>
                <th>Instructor</th>
                <th>Room/Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $key => $sub)
            <tr id="subject-wrapper">
                <td>
                    {{ $sub->Subjects->description }}
                    <input type="hidden" value="{{ $aes->encrypt($sub->id) }}" name="subjectID[]">
                </td>
                <td>
                    @php
                        $label = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                        $days = [$sub->mon, $sub->tue, $sub->wed, $sub->thu, $sub->fri, $sub->sat];
                    @endphp

                    @foreach($days as $i => $day)
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" name="days[{{ $key }}][{{ $i }}]" value="1" @checked($day)>
                        <label class="form-check-label" for="" style="font-size: 12px">{{ $label[$i] }}</label>
                    </div>
                    @endforeach
                </td>
                <td>
                    <div class="d-flex">
                        <input type="time" name="fromTime[]" value="{{ $sub->fromTime }}" class="form-control me-2">
                        <input type="time" name="toTime[]" value="{{ $sub->toTime }}" class="form-control">
                    </div>
                </td>
                <td>
                    <select name="instructor[]" class="form-select">
                        <option value="">Select...</option>
                        @foreach ($instructors as $in)
                            <option value="{{ $aes->encrypt($in->id) }}" @selected($sub->instructor == $in->id)>{{ $in->instructor }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="room[]" class="form-control" value="{{ $sub->room }}">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    @endif
</div>
