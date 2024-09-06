@extends('app')

@section('content')

<div class="container-xxl">
<div class="authentication-wrapper authentication-basic container-p-y">
  <div class="authentication-inner py-4">

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
              <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span> <span id="ampm">AM</span>
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
              const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
              const formattedDate = now.toLocaleDateString(undefined, options);
              document.getElementById('date').textContent = formattedDate;
          }
      
          updateClock();
          updateDate();
          setInterval(updateClock, 1000);
          setInterval(updateDate, 60000);  // Update date every minute
      </script>

        <div class="processing alert alert-success" style="display: none"></div>

        <div class="text-center">
            <a href="javascript:;">
                <img src="/assets/nfc.gif" class="" alt="" style="width: 250px; height: auto">
            </a>
            <div class="label-status text-danger mb-4"><small>Waiting for a card to be scanned...</small></div>
        </div>
    
        <div class="tex-center">
          <input type="text" class="form-control mb-3 text-center" id="rfid-number" min="10">
        </div>

        @include('layouts.footer')
    <!-- /Register -->
  </div>
  <div class="text-center">
    <a wire:navigate href="/" class="nav-link text-primary fw-bold mb-4"><iconify-icon icon="icon-park-twotone:back" width="18" height="18"></iconify-icon> Go Back</a>
  </div>
</div>
</div>


@endsection
