<!-- Modal -->
<div class="modal fade" id="edit-sms-token-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="update-sms-token">
        @csrf
        <input type="hidden" id="id" name="id" class="form-control">
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">SMS API Token</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-md-8 d-flex align-items-center">
                <h6 class="mb-3">Pushbullet Account Settings (SMS)</h6>
            </div>
            <div class="col-md-12">
                <p class="text-wrap text-justify text-sm">Pushbullet's API enables developers to build on the
                    Pushbullet infrastructure. Our goal is to provide a full API that enables anything to tap
                    into the Pushbullet network.
                    The Pushbullet API lets you send/receive pushes and do everything else the official
                    Pushbullet clients can do. To access the API you'll need an access token so the server knows
                    who you are. You can get one from your <a href="https://www.pushbullet.com/" target="_blank"
                        class="text-success text-decoration-underline">Account Settings</a> page.
                </p>
            </div>

            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <label for="" style="font-size: 12px;">Access Token</label>
              <input type="text" name="SMSAccessToken" id="SMSAccessToken" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Mobile Identity</label>
              <input type="text" name="SMSMobileIdentity" id="SMSMobileIdentity" class="form-control mb-2" required>

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