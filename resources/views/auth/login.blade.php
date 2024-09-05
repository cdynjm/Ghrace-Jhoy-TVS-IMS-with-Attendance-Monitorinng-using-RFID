@extends('app')

@section('content')

  <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->

  <div style="">
    <div class="authentication-wrapper authentication-cover">
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
          <div class="flex-row text-center mx-auto">
            <img
              src="/assets/graduation-cap.png"
              alt="Auth Cover Bg color"
              width="450"
              class="img-fluid authentication-cover-img"
              
            />
            <div class="mx-auto">
              <h3>Ghrace Jhoy Technical Vocational School</h3>
              <p>
                a TESDA-accredited institution dedicated to providing quality education and training in various vocational fields.
                <br>
                The school emphasizes practical training, allowing students to engage in hands-on learning experiences that prepare them for real-world applications
              </p>
            </div>
          </div>
        </div>
        <!-- /Left Text -->
  
        <!-- Login -->
        <div
          class="d-flex col-12 col-lg-5 col-xl-4 align-items-center p-sm-5 p-4"
        >
          <div class="w-px-400 mx-auto" style="z-index: 1000">
              <div class="card shadow-md shadow-lg-none">
                <div class="card-body">
                  <!-- Logo -->
              <div class="app-brand justify-content-center mb-0">
                <a href="#" class="app-brand-link gap-2">
                  <span class="">
                    <img src="/assets/school-logo.png" class="img-fluid avatar"alt="">
                  </span>
                  <span class="app-brand-text demo h5 fs-5 mb-0 fw-bold me-3">Ghrace Jhoy TVS</span>
                </a>
              </div>
              <!-- /Logo -->
              <hr class="my-4">
              <h6 class="mb-2">Information Management System </h6>
              <p class="mb-4">Please sign-in your credentials</p>
  
             
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
                    <a wire:navigate href="{{ route('forgot-password') }}">
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
                <a @if($status->status == 1) wire:navigate href="{{ route('register') }}" @else href="javascript:;" class="text-danger" id="admission-closed" @endif>
                  <small>Register Here!</small>
                </a>
              </p>
              @include('layouts.footer')
                </div>
              </div>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
  
    
  </div>

@endsection
