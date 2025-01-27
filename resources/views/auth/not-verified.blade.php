@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Email Verification'], 
        ['icon' => '
          
            <lord-icon
              src="https://cdn.lordicon.com/vpbspaec.json"
              trigger="in"
              stroke="bold"
              style="width:27px; height:27px">
            </lord-icon>
          
        '])
      
      <div class="content-wrapper">
        
          <div class="container-xxl flex-grow-1 container-p-y">

            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                  <li class="breadcrumb-item">
                    <a href="javascript:void(0);" class="fw-bold">Email is not Verified</a>
                  </li>
                 
                </ol>
            </nav>
            
            <div class="alert bg-warning text-white alert-dismissible d-flex align-items-center shadow-sm" role="alert">
                <div>
                    <i class='bx bxs-info-circle me-1'></i>
                    <small>
                        <span>We have sent you an email verification. Please check your inbox to verify your email address and follow the instructions to proceed.

                            If you haven’t received the email, you need to wait 10 minutes before it can be resent. To resend the verification email, you must log out and log back in, and the email will be sent automatically.</span>
                    </small>
                </div>
              </div>
         
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
