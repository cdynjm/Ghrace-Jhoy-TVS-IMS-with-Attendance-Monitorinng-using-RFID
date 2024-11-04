<div class="subject-list-data">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="20%">Subject</th>
                    <th width="5%">Days</th>
                    <th width="10%">Time</th>
                    <th>Instructor</th>
                    <th width="23%">Room/Location</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($subjects))
                    @foreach ($subjects as $key => $sub)
                        <tr>
                            <!-- Subject -->
                            <td>
                                {{ $sub->description }}
                                <input type="hidden" name="subjectID[]" value="{{ $sub->id }}">
                            </td>

                            <!-- Days (Checkboxes) in one row -->
                            <td>
                                @php
                                    $label = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                                @endphp
                                
                                    @foreach ($label as $i => $day)
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" name="days[{{ $key }}][{{ $i }}]" value="1">
                                            <label class="form-check-label ms-1" style="font-size: 12px">{{ $day }}</label>
                                        </div>
                                    @endforeach
                               
                            </td>

                            <!-- Time - FROM | TO -->
                            <td>
                                <div class="d-block">
                                    <label for="" style="font-size: 12px">From</label>
                                    <input type="time" name="fromTime[]" class="form-control mb-2" placeholder="From">
                                    <label for="" style="font-size: 12px">To</label>
                                    <input type="time" name="toTime[]" class="form-control" placeholder="To">
                                </div>
                            </td>

                            <!-- Instructor -->
                            <td>
                                <select name="instructor[]" class="form-select" required>
                                    <option value="">Select...</option>
                                    @foreach ($instructors as $in)
                                        <option value="{{ $aes->encrypt($in->id) }}">{{ $in->instructor }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <!-- Room/Location -->
                            <td>
                                <input type="text" name="room[]" class="form-control" placeholder="Room/Location">
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

