<!-- Modal -->
<div class="modal fade" id="create-course-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="create-course">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Course/Qualification</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <label for="" style="font-size: 12px;">Sector</label>
              <input type="text" name="sector" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Qualification</label>
              <input type="text" name="qualification" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Status</label>
              <input type="text" name="status" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">COPR #</label>
              <input type="text" name="copr" class="form-control mb-2" required>
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