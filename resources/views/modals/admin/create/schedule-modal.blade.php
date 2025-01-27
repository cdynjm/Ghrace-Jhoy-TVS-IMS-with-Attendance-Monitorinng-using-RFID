<!-- Modal -->
<div class="modal fade" id="create-schedule-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form class="modal-content" id="create-schedule">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-2">

              <input type="hidden" class="form-control" name="id" id="course-id">

              @php
                $currentYear = date('Y'); // Get the current year
                $currentMonth = date('n'); // Get the current month
                
                // Determine the current school year based on the current date
                if ($currentMonth >= 8) {
                    // If current month is August (8) or later, it's the next school year
                    $selectedYear = $currentYear;
                } else {
                    // If current month is before August, it's still the previous school year
                    $selectedYear = $currentYear - 1;
                }

                // Generate only the previous, current, and next school years
                $years = [
                    $selectedYear - 1,  // Previous school year
                    $selectedYear,      // Current school year
                    $selectedYear + 1   // Next school year
                ];
            @endphp


              <div class="row">
                <div class="col-md-3  mb-4">
                  <label for="" style="font-size: 12px;">School Year</label>
                  <select name="schoolYear" class="form-select">
                    @foreach ($years as $year)
                        <option value="{{ $year }}-{{ $year + 1 }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}-{{ $year + 1 }}
                        </option>
                    @endforeach
                </select>
                </div>
                <div class="col-md-3 mb-4">
                  <label for="" style="font-size: 12px;">Year Level/Semester</label>
                  <select name="yearLevel" id="yearLevel" class="form-select yearLevel" required>
                      <option value="">Select...</option>
                      @foreach ($courseInfo as $ci)
                        <option value="{{ $aes->encrypt($ci->id) }}">{{ $ci->yearLevel }} - {{ $ci->semester }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-md-3 mb-4">
                  <label for="" style="font-size: 12px;">Section</label>
                  <input type="text" name="section" class="form-control" placeholder="Section" required>
                </div>
                <div class="col-md-3 mb-4">
                  <label for="" style="font-size: 12px;">Slots</label>
                  <input type="number" class="form-control" name="slots" placeholder="Slots" required>    
                </div>
              </div>
             
              @include('modals.admin.create.subjects.subject-list')

            </div>

            <div class="col-md-12">
              <div class="error-sched alert alert-danger" style="display: none"></div>
              <div class="processing alert alert-success" style="display: none"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-sm btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>