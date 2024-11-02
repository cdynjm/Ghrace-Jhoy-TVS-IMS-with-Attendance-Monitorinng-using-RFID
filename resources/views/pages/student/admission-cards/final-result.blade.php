<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            @if(Auth::user()->Student->status == 6 || (Auth::user()->Student->status == 7 && Auth::user()->Student->admission_status == 1))
            <h6>Congratulations!</h6>
            @endif
            @if(Auth::user()->Student->admission_status == 2)
            <h6>Enrollment Cancelled</h6>
            @endif
            <hr class="my-2">
        </div>
        <div class="card-body">
            @if(Auth::user()->Student->status == 6)
            <div class="alert alert-solid-warning alert-dismissible d-flex align-items-center" role="alert">
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
            @if(Auth::user()->Student->status == 7 && Auth::user()->Student->admission_status == 1)
            <div class="alert alert-solid-success text-white alert-dismissible d-flex align-items-center" role="alert">
                <div>

                    <i class='bx bxs-info-circle me-1' ></i>
                    
                    <small>
                        We are pleased to inform you that you have successfully passed the admission application. You are now ready to proceed with the enrollment.

                        Thank you for your patience during this process. We will provide you with further instructions on the next steps for enrollment shortly.
                    </small>
                    
                </div>
            </div>
            <a wire:navigate href="{{ route('student.proceed-enrollment') }}" class="btn btn-sm btn-primary"><i class='fas fa-check me-1' ></i> Proceed to Enrollment</a>
            <a wire:navigate href="{{ route('student.cancel-enrollment') }}" class="btn btn-sm btn-danger"><i class='fas fa-times me-1' ></i> Cancel Enrollment</a>
            @endif

            @if(Auth::user()->Student->admission_status == 2)
            <div class="alert alert-solid-danger text-white alert-dismissible d-flex align-items-center" role="alert">
                <div>
                    <i class='bx bxs-info-circle me-1'></i>
                    <small>
                        We’ve noticed that you have canceled your enrollment. If this was unintentional, or if you would like to discuss any concerns or questions regarding your enrollment status, please don’t hesitate to reach out to the school registrar's office. The registrar team is available to provide more information and assist you with any steps you may need to take moving forward.
                    </small>
                </div>
            </div>            
            @endif
        </div>
    </div>
</div>
