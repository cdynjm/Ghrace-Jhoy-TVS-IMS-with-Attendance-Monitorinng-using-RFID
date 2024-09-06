<!-- Modal -->
<div class="modal fade" id="edit-course-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="update-course">
        @csrf
        <input type="hidden" id="id" name="id" class="form-control">
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Course/Qualification</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <input type="hidden" name="id" id="course-id" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Sector</label>
              <input type="text" name="sector" id="sector" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Qualification</label>
              <input type="text" name="qualification" id="qualification" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Status</label>
              <input type="text" name="status" id="status" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">COPR #</label>
              <input type="text" name="copr" id="copr" class="form-control mb-2" required>
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