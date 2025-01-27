<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h6>Congratulations!</h6>
            <hr class="my-2">
        </div>
        <div class="card-body">
            <div class="alert alert-primary alert-dismissible d-flex align-items-center" role="alert">
                <div>
                    <i class='bx bxs-info-circle me-1' ></i>
                    <small>
                        Congratulations! You have passed the entrance exam and are scheduled for an interview on <b>{{ date('M d, Y', strtotime(Auth::user()->Student->interview)) }}</b>. We look forward to seeing you there!
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
