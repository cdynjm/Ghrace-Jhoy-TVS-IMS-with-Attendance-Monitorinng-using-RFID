<!-- Modal -->
<div class="modal fade" id="edit-employment-status-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="update-employment-status">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Employment Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <input type="hidden" name="id" id="course-id" class="form-control mb-2" required>
              <input type="hidden" name="studentID" id="student-id" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Employment Status</label>
              <select name="employmentStatus" id="graduate-employment-status" class="form-select" required>
                <option value="">Select...</option>
                <option value="0">Unemployed</option>
                <option value="1">Employed</option>
              </select>

              <label for="" style="font-size: 12px;">Company</label>
              <input type="text" name="company" id="company" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Date Hired</label>
              <input type="date" name="dateHired" id="date-hired" class="form-control mb-2" required>

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