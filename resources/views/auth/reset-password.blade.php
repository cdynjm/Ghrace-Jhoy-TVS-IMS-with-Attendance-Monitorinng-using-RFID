@extends('app')

@section('content')

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
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto" style="z-index: 1000">
                    <div class="card shadow-md shadow-lg-none">
                        <div class="card-body">
                            <div class="app-brand justify-content-center mb-0">
                                <a href="#" class="app-brand-link gap-2">
                                    <span class="">
                                        <img src="/assets/school-logo.png" class="img-fluid avatar" alt="">
                                    </span>
                                    <span class="app-brand-text demo h5 fs-5 mb-0 fw-bold me-3">Ghrace Jhoy TVS</span>
                                </a>
                            </div>
                            <hr class="my-4">
                            <h6 class="mb-2">Reset Password</h6>
                            <p class="mb-4">Please provide a new password</p>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                   
                                </div>
                            @endif

                            <form id="resetPasswordForm" action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter your email" value="{{ $email ?? old('email') }}" readonly required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
                                </div>
                            </form>

                            <p class="text-center">
                                <small>Back to </small>
                                <a wire:navigate href="{{ route('login') }}" class="text-primary">
                                    <small>Login</small>
                                </a>
                            </p>
                            @include('layouts.footer')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
