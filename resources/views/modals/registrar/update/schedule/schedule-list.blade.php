<div id="schedule-list">
    @php
        $groupedSchedules = $schedule->groupBy(function($sc) {
            return $sc->CourseInfo->yearLevel . ' | ' . $sc->CourseInfo->semester;
        });
    @endphp

    <select name="schedule" class="form-select" required>
    <option value="">Select...</option>
    @foreach ($groupedSchedules as $group => $schedules)
        <optgroup label="{{ $group }}">
            @foreach ($schedules as $sc)
                <option value="{{ $aes->encrypt($sc->id) }}">
                    Section {{ $sc->section }} | Slots: {{ $sc->enrolled }}/{{ $sc->slots }}
                </option>
            @endforeach
        </optgroup>
    @endforeach
    </select>
</div>