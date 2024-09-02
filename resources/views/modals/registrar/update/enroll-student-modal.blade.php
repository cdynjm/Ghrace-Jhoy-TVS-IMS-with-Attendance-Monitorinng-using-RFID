<!-- Modal -->
<div class="modal fade" id="enroll-student-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="submit-enroll-student">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Enroll Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

             <input type="hidden" id="student-id" name="studentID" class="form-control" required>
             <input type="hidden" id="course-id" name="id" class="form-control" required>

              <label for="" style="font-size: 12px;">Year | Semester | Section</label>
              @include('modals.registrar.update.schedule.schedule-list')


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