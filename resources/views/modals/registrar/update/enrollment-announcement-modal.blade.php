<!-- Modal -->
<div class="modal fade" id="enrollment-announcement-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="update-enrollment-announcement">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Enrollment Announcement Date</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

              <div class="form-check form-switch m-0 mb-3">
                <input class="form-check-input" name="enable" id="toggle-enrollment" 
                       @checked(\App\Models\Announcement::where('id', 1)->first()->enable == 1) 
                       type="checkbox" value="{{ $aes->encrypt('1') }}">
                <label for="" style="font-size: 12px">START ENROLLMENT</label>  
            </div> 
            
            <label for="" style="font-size: 12px">DATE START/OPEN</label>  
            <input type="date" name="open" id="open-date" class="form-control" 
                   value="{{ \App\Models\Announcement::where('id', 1)->first()->open }}" 
                   @disabled(\App\Models\Announcement::where('id', 1)->first()->enable == 0)>
            
            <label for="" style="font-size: 12px">DATE END/CLOSE</label>  
            <input type="date" name="close" id="end-date" class="form-control" 
                   value="{{ \App\Models\Announcement::where('id', 1)->first()->close }}" 
                   @disabled(\App\Models\Announcement::where('id', 1)->first()->enable == 0)>
            


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