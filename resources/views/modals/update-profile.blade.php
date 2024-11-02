<div class="modal fade" id="edit-user-profile-modal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="update-user-profile">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Update Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="processing alert alert-success" style="display: none"></div>

            <!-- Error message alert -->
            <div id="error-message" class="alert alert-danger" style="display: none"></div>

            <label for="" style="font-size: 12px;">Name @if(Auth::user()->role == 4) 
              <span class="text-danger">You cannot change your name for confidentiality reasons</span> 
            @endif</label>
            <input type="text" name="profileName" class="form-control mb-2" 
                   @readonly(Auth::user()->role == 4) required>

            <label for="" style="font-size: 12px;">Email</label>
            <input type="email" name="profileEmail" class="form-control mb-2" required>

            <label for="" style="font-size: 12px;">Current Password</label>
            <input type="password" name="currentPassword" class="form-control mb-2" required>

            <label for="" style="font-size: 12px;">New Password</label>
            <input type="password" name="newPassword" class="form-control mb-2">

            <label for="" style="font-size: 12px;">Confirm New Password</label>
            <input type="password" name="confirmPassword" class="form-control mb-2">
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
