<div id="interview-data">
    @php
        $data = false;
    @endphp
    <p class="fw-bold">1st Interview</p>
    @foreach ($learnersProfile as $interviewDate => $profile)
        @php
            $count = 0
        @endphp
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-sm">{{ date('M d, Y', strtotime($interviewDate)) }}</h6>
            <div class="btn-group">
                <button class="btn btn-sm btn-primary shadow text-white me-2" id="proceed-to-second-interview" data-proceed-index="{{ $loop->index }}"><i class="fas fa-check me-1"></i> Proceed</button>
                <button class="btn btn-sm btn-danger shadow text-white" id="failed-interview" data-proceed-index="{{ $loop->index }}"><i class="fas fa-times me-1"></i> Failed</button>    
            </div>
        </div>
        
        <div class="card-body">
            <div class="mb-2">
                <input type="checkbox" class="me-2 masterCheckbox-interview-{{ $loop->index }}" id="masterCheckbox-interview" data-index="{{ $loop->index }}">
                <label for="masterCheckbox-exam-{{ $loop->index }}"><small>Select All</small></label>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover" style="border-bottom: 1px solid rgb(240, 240, 240)">
                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                        <tr>
                            <th class="text-nowrap">#</th>
                            <th class="text-nowrap"><small>Applicant Name</small></th>
                            <th class="text-nowrap"><small>Address</small></th>
                            <th class="text-nowrap"><small>Registration Date</small></th>
                            <th class="text-nowrap"><small>Exam Date</small></th>
                            <th class="text-nowrap"><small>Qualification</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profile as $lp)
                            @php
                                $count += 1;
                            @endphp
                            <tr>
                                <td class="text-nowrap"><small><input type="checkbox" class="childCheckbox-interview-{{ $loop->parent->index }} me-2" id="childCheckbox-interview" data-parent-index="{{ $loop->parent->index }}" name="applicant[]" value="{{ $aes->encrypt2($lp->id) }}"> {{ $count }}</small></td>
                                <td class="text-nowrap"><small>{{ $lp->lastname }}, {{ $lp->firstname }} {{ $lp->middlename }}</small></td>
                                <td class="text-nowrap"><small>{{ $lp->Barangay->brgyDesc }}, {{ ucwords(strtolower($lp->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($lp->Province->provDesc)) }} - {{ $lp->Region->regDesc }}</small></td>
                                <td class="text-nowrap"><small>{{ date('M d, Y', strtotime($lp->created_at)) }}</small></td>
                                <td class="text-nowrap"><small>{{ date('M d, Y', strtotime($lp->exam)) }}</small></td>
                                <td class="text-nowrap"><small>{{ $learnersCourse->where('studentID', $lp->id)->first()->Course->qualification }}</small></td>
                            </tr>
                        @endforeach
                        @if($count == 0)
                            <tr>
                                <td colspan="10" class="text-center"><small>No Data Found</small></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php
        $data = true;
    @endphp
    @endforeach
    @if($data == false)
        <div class="card">
            <div class="card-header text-center">
                <small>No Data Found</small>
            </div>
        </div>
    @endif

    @php
        $secondData = false;
    @endphp
    <p class="fw-bold mt-4">2nd Interview</p>
    @foreach ($secondLearnersProfile as $interviewDate => $profile)
        @php
            $count = 0
        @endphp
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-sm">{{ date('M d, Y', strtotime($interviewDate)) }}</h6>
            <div class="btn-group">
                <button class="btn btn-sm btn-primary shadow text-white me-2" id="proceed-to-final-result" data-proceed-index="{{ $loop->index }}"><i class="fas fa-check me-1"></i> Done</button>
            </div>
        </div>
        
        <div class="card-body">
            <div class="mb-2">
                <input type="checkbox" class="me-2 masterCheckbox-second-interview-{{ $loop->index }}" id="masterCheckbox-second-interview" data-index="{{ $loop->index }}">
                <label for="masterCheckbox-exam-{{ $loop->index }}"><small>Select All</small></label>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover" style="border-bottom: 1px solid rgb(240, 240, 240)">
                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                        <tr>
                            <th class="text-nowrap">#</th>
                            <th class="text-nowrap"><small>Applicant Name</small></th>
                            <th class="text-nowrap"><small>Address</small></th>
                            <th class="text-nowrap"><small>Registration Date</small></th>
                            <th class="text-nowrap"><small>Exam Date</small></th>
                            <th class="text-nowrap"><small>Qualification</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profile as $lp)
                            @php
                                $count += 1;
                            @endphp
                            <tr>
                                <td class="text-nowrap"><small><input type="checkbox" class="childCheckbox-second-interview-{{ $loop->parent->index }} me-2" id="childCheckbox-second-interview" data-parent-index="{{ $loop->parent->index }}" name="applicant[]" value="{{ $aes->encrypt2($lp->id) }}"> {{ $count }}</small></td>
                                <td class="text-nowrap"><small>{{ $lp->lastname }}, {{ $lp->firstname }} {{ $lp->middlename }}</small></td>
                                <td class="text-nowrap"><small>{{ $lp->Barangay->brgyDesc }}, {{ ucwords(strtolower($lp->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($lp->Province->provDesc)) }} - {{ $lp->Region->regDesc }}</small></td>
                                <td class="text-nowrap"><small>{{ date('M d, Y', strtotime($lp->created_at)) }}</small></td>
                                <td class="text-nowrap"><small>{{ date('M d, Y', strtotime($lp->exam)) }}</small></td>
                                <td class="text-nowrap"><small>{{ $learnersCourse->where('studentID', $lp->id)->first()->Course->qualification }}</small></td>
                            </tr>
                        @endforeach
                        @if($count == 0)
                            <tr>
                                <td colspan="10" class="text-center"><small>No Data Found</small></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php
        $secondData = true;
    @endphp
    @endforeach
    @if($secondData == false)
        <div class="card">
            <div class="card-header text-center">
                <small>No Data Found</small>
            </div>
        </div>
    @endif
    </div>
    