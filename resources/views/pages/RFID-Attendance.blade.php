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
                <p class="mb-3">Dear Students,</p>
                <p class="mb-3">
                    Please be reminded of the RFID scanning protocol for attendance purposes. Each day, you are permitted a maximum of four scans to record both morning and afternoon attendance:
                </p>
                <ul class="mb-3">
                    <li><strong>First Scan (Morning In):</strong> This is for your <em>Morning Time In</em>.</li>
                    <li><strong>Second Scan (Morning Out):</strong> This is for your <em>Morning Time Out</em>.</li>
                    <li><strong>Third Scan (Afternoon In):</strong> This is for your <em>Afternoon Time In</em>.</li>
                    <li><strong>Fourth Scan (Afternoon Out):</strong> This is for your <em>Afternoon Time Out</em>.</li>
                </ul>
                <p class="mb-3">
                    <strong>Important:</strong> <span class="text-danger">
                        Please follow these guidelines to ensure accurate attendance records:
                    </span>
                </p>
                <ul class="mb-3">
                    <li>If your first scan of the day occurs in the afternoon, it will record as your <em>Afternoon Time In</em>. A second scan in the afternoon will then log as your <em>Afternoon Time Out</em>, and no further scans will be allowed for that day.</li>
                    <li>Each period (morning and afternoon) has a maximum of two scans: one for <em>Time In</em> and one for <em>Time Out</em>. Ensure you are scanning at the correct time for each period.</li>
                    <li>If you attempt to scan for a third time in the morning before 12:00 PM, it will not be registered, as only one <em>Time In</em> and one <em>Time Out</em> scan are allowed per period.</li>
                </ul>
                <p class="mb-0">Thank you for your cooperation!</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
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
                setInterval(updateDate, 60000);
              </script>

              <div class="processing alert alert-success" style="display: none"></div>

              <div class="text-center">
                <a href="javascript:;">
                  <img src="/assets/nfc.gif" class="" alt="" style="width: 250px; height: auto">
                </a>
                <div class="label-status text-danger mb-4"><small>Waiting for a card to be scanned...</small></div>
              </div>

              <div class="text-center">
                <input type="text" class="form-control mb-3 text-center" id="rfid-number" style="position: absolute; left: -9999999px;"  min="10" autofocus>
              </div>

              @include('layouts.footer')

              <div class="text-center">
                <a class=" btn btn-sm btn-primary" href="javascript:;" id="sign-out">
                  <i class="bx bx-power-off me-1"></i>
                  <span class="align-middle">Log Out</span>
              </a>
              </div>
            </div>
          </div>
        </div>
        
      </div>

    </div>
  </div>
</div>
@endsection
