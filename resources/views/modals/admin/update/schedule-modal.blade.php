<!-- Modal -->
<div class="modal fade" id="edit-schedule-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form class="modal-content" id="update-schedule">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <input type="hidden" class="form-control" name="scheduleID" id="schedule-id">
              <input type="hidden" class="form-control course-id" name="id">

              <label for="" style="font-size: 12px;">School Year</label>
              <input type="text" name="schoolYear" id="school-year" class="form-control mb-2" placeholder="School Year" required>

              <label for="" style="font-size: 12px;">Year Level/Semester</label>
              <select name="yearLevel" id="yearLevel" class="form-select yearLevel" disabled>
                  <option value="">Select...</option>
                  @foreach ($courseInfo as $ci)
                    <option value="{{ $aes->encrypt($ci->id) }}">{{ $ci->yearLevel }} - {{ $ci->semester }}</option>
                  @endforeach
              </select>

              <label for="" style="font-size: 12px;">Section</label>
              <input type="text" name="section" id="section" class="form-control mb-2" placeholder="Section" required>
              
              <label for="" style="font-size: 12px;">Slots</label>
              <input type="number" class="form-control mb-2" name="slots" id="slots" placeholder="Slots" required>

              @include('modals.admin.update.subjects.subject-list')

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