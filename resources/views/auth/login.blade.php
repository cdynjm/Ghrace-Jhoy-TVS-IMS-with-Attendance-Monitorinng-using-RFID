@extends('app')

@section('content')

  <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- Content -->
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">

        <!-- Login -->
        <div class="card">
          <div class="card-body">

            <!-- Logo -->
            <div class="app-brand justify-content-center mb-0">
              <a href="#" class="app-brand-link gap-2">
                <span class="">
                  <img src="/assets/school-logo.png" class="img-fluid avatar"alt="">
                </span>
                <span class="app-brand-text demo h5 fs-4 mb-0 fw-bold me-2">Ghrace Jhoy TVS</span>
              </a>
            </div>
            <!-- /Logo -->
            <hr class="my-4">
            <h5 class="mb-2">Information Management System </h5>
            <p class="mb-4">Please sign-in to your credentials</p>

           
            <div id="error" class="alert alert-danger text-xs" style="display: none"></div>
            <div id="authenticating" class="alert alert-success text-xs" style="display: none;"></div>
            
            <form id="formAuthentication" action="" class="sign-in mb-3">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label text-capitalize">Email or Username</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="" autofocus>
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label text-capitalize" for="password">Password</label>
                  <a href="auth-forgot-password-basic.html">
                    <small>Forgot Password?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                  <span class="input-group-text cursor-pointer" id="show-password"><i class="far fa-eye-slash"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me">
                  <label class="form-check-label" for="remember-me">
                    Remember Me
                  </label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
            </form>

            <div class="divider my-4">
              <div class="divider-text">or</div>
            </div>
            
            <p class="text-center">
              <small>Apply for Admission, </small>
              <a wire:navigate href="{{ route('register') }}">
                <small>Register Here!</small>
              </a>
            </p>

            <!--
            <div class="divider my-4">
              <div class="divider-text">or</div>
            </div>

            <div class="d-flex justify-content-center">
              <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                <i class="tf-icons bx bxl-facebook"></i>
              </a>
              <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                <i class="tf-icons bx bxl-google-plus"></i>
              </a>
              <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                <i class="tf-icons bx bxl-twitter"></i>
              </a>
            </div> 
          -->

          </div>
        </div>
        <!-- /Register -->

      </div>
    </div>
  </div>
  <!-- /Content -->
  @include('layouts.footer')
@endsection
