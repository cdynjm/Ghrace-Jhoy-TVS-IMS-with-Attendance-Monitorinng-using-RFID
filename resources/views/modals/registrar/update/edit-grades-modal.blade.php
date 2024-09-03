<!-- Modal -->
<div class="modal fade" id="edit-grades-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="update-grades">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Edit Grades</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <input type="hidden" name="id" id="student-id" class="form-control mb-2" required>
              <input type="hidden" name="gradeID" id="grade-id" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Midterm Grade</label>
              <input type="number" min="0" step="0.01" name="mt" id="mt" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Final Term Grade</label>
              <input type="number" min="0" step="0.01" name="ft" id="ft" class="form-control mb-2" required>

              <div class="resultant-subject" style="display: none">
                <label for="" style="font-size: 12px;">Mandatory Assessment Status</label>
                <select name="assessment" id="assessment" class="form-select">
                  <option value="0">Select...</option>
                  <option value="1">COMPETENT</option>
                  <option value="2">NOT YET COMPETENT</option>
                </select>
              </div>

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