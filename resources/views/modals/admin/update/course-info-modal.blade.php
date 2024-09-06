<!-- Modal -->
<div class="modal fade" id="edit-course-info-modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form class="modal-content" id="update-course-info">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Edit Course Subjects</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">

              <div class="processing alert alert-success" style="display: none"></div>

             <input type="hidden" name="id" class="form-control course-id" required>

             <input type="hidden" name="courseInfoID" class="form-control course-info-id" required>

             <label for="" style="font-size: 12px;">Year Level</label>
              <select name="year" id="edit-year-level" class="form-select mb-2" required>
                <option value="">Select...</option>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
                <option value="5th Year">5th Year</option>
              </select>

              <label for="" style="font-size: 12px;">Semester</label>
              <select name="semester" id="edit-semester" class="form-select mb-2" required>
                <option value="">Select...</option>
                <option value="1st Semester">1st Semester</option>
                <option value="2nd Semester">2nd Semester</option>
              </select>

            <label for="" style="font-size: 13px;">Subject Code | Description | Units</label>
            @include('modals.admin.update.subjects.course-subject-list')
            <button type="button" class="btn btn-sm btn-success edit-add-subject"><i class="fa-solid fa-plus"></i></button>

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