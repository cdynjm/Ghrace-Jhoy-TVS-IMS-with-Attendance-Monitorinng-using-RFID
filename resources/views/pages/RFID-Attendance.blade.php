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
