<!-- Modal -->
<div class="modal fade" id="edit-student-information-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="update-student-information">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">RFID & ULI</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <input type="hidden" name="id" id="course-id" class="form-control mb-2" required>
              <input type="hidden" name="studentID" id="student-id" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">RFID Card Number</label>
              <input type="text" name="RFID" id="RFID" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">ULI</label>
              <input type="text" name="ULI" id="ULI" class="form-control mb-2" required>

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