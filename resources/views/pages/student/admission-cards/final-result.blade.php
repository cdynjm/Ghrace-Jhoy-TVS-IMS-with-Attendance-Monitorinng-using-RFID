<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h6>Congratulations!</h6>
            <hr class="my-2">
        </div>
        <div class="card-body">
            @if(Auth::user()->Student->status == 6)
            <div class="alert alert-solid-danger alert-dismissible d-flex align-items-center" role="alert">
                <div>

                    <i class='bx bxs-info-circle me-1' ></i>
                    
                    <small>
                        Please be informed that you have successfully completed the entrance exam and the interview for admission. Your enrollment application is now under final evaluation by the school. This evaluation will determine whether your application to enroll has been approved or not.
                        We appreciate your patience during this process and will notify you of the outcome as soon as it is available.
                        Thank you for your understanding.
                    </small>
                    
                </div>
            </div>
            @endif
            @if(Auth::user()->Student->status == 7)
            <div class="alert alert-solid-success text-dark alert-dismissible d-flex align-items-center" role="alert">
                <div>

                    <i class='bx bxs-info-circle me-1' ></i>
                    
                    <small>
                        We are pleased to inform you that you have successfully passed the admission application. You are now ready to proceed with the enrollment.

                        Thank you for your patience during this process. We will provide you with further instructions on the next steps for enrollment shortly.
                    </small>
                    
                </div>
            </div>
            <a wire:navigate href="{{ route('student.proceed-enrollment') }}" class="btn btn-sm btn-primary"><i class='fas fa-check me-1' ></i> Proceed to Enrollment</a>
            @endif
        </div>
    </div>
</div>
