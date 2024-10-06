@extends('app')

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <div class="row">
        <div class="col-md-8 mb-4">
          
          <div class="card">
            <div class="card-header">
                <h5 class="text-primary">Important Notice for RFID Attendance</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">
                    Dear Students,
                </p>
                <p class="mb-3">
                    Please be reminded that you are only allowed to scan your RFID card twice a day for attendance purposes:
                </p>
                <ul class="mb-3">
                    <li><strong>First Scan:</strong> This is for <em>Time In</em>.</li>
                    <li><strong>Second Scan:</strong> This is for <em>Time Out</em>.</li>
                </ul>
                <p class="mb-3">
                    Once you have scanned your RFID twice (Time In and Time Out), you will no longer be able to scan again for the day, as you will have already completed your attendance for that day.
                </p>
                <p class="mb-3">
                    <strong>Important:</strong> <span class="text-danger">
                        Please take note of the following points to avoid issues with your attendance records:
                    </span>
                </p>
                <ul class="mb-3">
                    <li>Do not scan your RFID card again after you have already logged in. Scanning multiple times for <em>Time In</em> will not be allowed.</li>
                    <li>Ensure you only scan your RFID card when you are ready to log out. Scanning unnecessarily can affect your attendance and will be automatically recorded as your <em>Time Out</em>.</li>
                    <li>Once you have logged out by scanning for the second time, further scans will be rejected, and your attendance will be considered complete for the day.</li>
                </ul>
                <p class="mb-0">
                    Thank you for your cooperation!
                </p>
            </div>
        </div>

        </div>
        <div class="col-md-4">
             <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="d-flex justify-content-center align-items-center mb-4">
            <div>
              <img src="/assets/rfid.png" alt="" style="width: 70px; height: auto">
            </div>
            <div>
              <h6 style="margin-top: 40px" class="ms-2">ATTENDANCE MONITORING</h6>
            </div>
          </div>
          <h6 class="text-center text-primary">PLEASE SCAN YOUR RFID CARD</h6>
          <hr>

          <div class="col-md-12 mb-4 text-center">
            <div id="clock" class="clock fs-1 fw-bold ms-auto">
              <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
              <span id="ampm">AM</span>
            </div>
            <div id="date" class="date fs-6 fw-normal ms-auto mb-3"></div>
          </div>
          <script>
            function updateClock() {
                const now = new Date();
                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';

                hours = hours % 12;
                hours = hours ? hours : 12;
                hours = String(hours).padStart(2, '0');

                document.getElementById('hours').textContent = hours;
                document.getElementById('minutes').textContent = minutes;
                document.getElementById('seconds').textContent = seconds;
                document.getElementById('ampm').textContent = ampm;
            }

            function updateDate() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const formattedDate = now.toLocaleDateString(undefined, options);
                document.getElementById('date').textContent = formattedDate;
            }

            updateClock();
            updateDate();
            setInterval(updateClock, 1000);
            setInterval(updateDate, 60000); // Update date every minute
          </script>

          <div class="processing alert alert-success" style="display: none"></div>

          <div class="text-center">
            <a href="javascript:;">
              <img src="/assets/nfc.gif" class="" alt="" style="width: 250px; height: auto">
            </a>
            <div class="label-status text-danger mb-4"><small>Waiting for a card to be scanned...</small></div>
          </div>

          <div class="tex-center">
            <input type="text" class="form-control mb-3 text-center" id="rfid-number" style="position: absolute; left: -9999999px;" min="10" autofocus>
          </div>


          @include('layouts.footer')
          <!-- /Register -->
        </div>
      

              <div class="text-center">
                <a href="/" class="nav-link text-primary fw-bold mb-4">
                  <iconify-icon icon="icon-park-twotone:back" width="18" height="18"></iconify-icon> Go Back
                </a>
              </div>
      </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection