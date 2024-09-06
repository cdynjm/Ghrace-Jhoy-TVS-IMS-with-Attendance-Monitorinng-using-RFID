<!-- Modal -->
<div class="modal fade" id="create-instructor-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="create-instructor">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Instructor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <label for="" style="font-size: 12px;">Instructor</label>
              <input type="text" name="instructor" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Address</label>
              <input type="text" name="address" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Contact Number</label>
              <input type="text" name="contactNumber" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Degree and Major</label>
              <input type="text" name="degree" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Email</label>
              <input type="email" name="email" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Password</label>
              <input type="password" name="password" class="form-control mb-2" required>

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