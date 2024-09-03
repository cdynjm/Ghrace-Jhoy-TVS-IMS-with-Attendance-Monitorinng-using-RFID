<!-- Modal -->
<div class="modal fade" id="create-course-info-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form class="modal-content" id="create-course-info">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Course Subjects</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

             <input type="hidden"  name="id" class="form-control course-id" required>

              <label for="" style="font-size: 12px;">Year Level</label>
              <input type="text" name="year" class="form-control mb-2" required>

              <label for="" style="font-size: 12px;">Semester</label>
              <input type="text" name="semester" class="form-control mb-2" required>

              <label for="" style="font-size: 13px;">Subject Code | Description | Units</label>
            <div id="subject-wrapper">
                <div class="subject-group mb-2 d-flex">
                    <input type="text" name="subjectCode[]" class="form-control me-2" placeholder="Code" required>
                    <input type="text" name="description[]" class="form-control me-2" placeholder="Description" required>
                    <input type="number" name="units[]" class="form-control" placeholder="Units" required>
                </div>
              
              <div class="form-check form-switch my-3">
                <input type="checkbox" name="NC[]" value="1" class="form-check-input me-2">
                <label for="" style="font-size: 12px;">Resultant Subject (NC II)</label>
              </div>
                
            </div>
            <button type="button" class="btn btn-sm btn-success add-subject"><i class="fa-solid fa-plus"></i></button>
            <button type="button" class="btn btn-sm btn-danger remove-subject"><i class="fa-solid fa-trash"></i></button>


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