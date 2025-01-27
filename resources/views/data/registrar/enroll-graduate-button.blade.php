<div id="enroll-graduate-button-data">
    @if($student->enrollmentStatus == 3)
        <a wire:navigate href="{{ route('registrar.update-enrollment-status', ['id' => $aes->encrypt2($student->LearnersCourse->course), 'studentID' => $aes->encrypt($student->id)]) }}" class="btn btn-sm btn-primary shadow-sm ms-2">
            Proceed to Enrollment
        </a>
    @endif

    @if($student->enrollmentStatus == 2 && $student->diploma == null)
        <button class="btn btn-sm btn-primary ms-2" data-id="{{ $aes->encrypt($student->id) }}" id="graduate-student">
            <iconify-icon icon="streamline:graduation-cap-solid" width="18" height="18" class="me-1"></iconify-icon> Graduate/Diploma
        </button>
    @endif
</div>