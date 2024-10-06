<div id="edit-subject-wrapper" class="edit-course-subject-list-data">
    
    @if(!empty($subjects))
        @foreach ($subjects as $key => $sub)
        <div class="subject-group mb-2 d-flex">
            <input type="hidden" name="subjectID[]" class="form-control me-2" value="{{ $aes->encrypt($sub->id) }}" placeholder="Code" required>
            <input type="text" name="subjectCode[]" class="form-control me-2" value="{{ $sub->subjectCode }}" placeholder="Code" required>
            <input type="text" name="description[]" class="form-control me-2" value="{{ $sub->description }}" placeholder="Description" required>
            <input type="number" name="units[]" class="form-control" value="{{ $sub->units }}" placeholder="Units" required>
        </div>
      
        <div class="form-check form-switch my-3">
            <input type="checkbox" name="NC[{{ $key }}]" value="1" class="form-check-input me-2" @checked($sub->NC == 1)>
            <label for="" style="font-size: 12px;">Resultant Subject (NC)</label>
        </div>
        @endforeach
    @endif
    
</div>