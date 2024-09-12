@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    use App\Models\AdmissionApplication;
    use App\Models\SMSToken;
    use App\Models\ChMessage;

    $chat = ChMessage::where('to_id', Auth::user()->id)->where('seen', 0)->count();
    $sms = SMSToken::first();
    $aes = new AESCipher();
@endphp

@extends('modals.update-profile')
@extends('modals.admin.update.edit-sms-token')

<div class="header-navbar-shadow"></div>
<!-- Navbar -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar" style="position: fixed; z-index: 9;">
  <div class="container-xxl">
      <!-- Menu Toggle -->
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
          </a>
      </div>

      <!-- Navbar Right -->
      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
          <!-- Search -->
          <div class="navbar-nav align-items-center">
              <div class="nav-item navbar-search-wrapper mb-0">
                  <a class="menu-link px-0" href="javascript:void(0);">
                    <span class="me-2 mt-1">  {!! $icon !!} </span>
                    <div class="d-md-inline-block fw-normal text-dark">{{ $page }}</div>
                  </a>
              </div>
          </div>

          <!-- User Menu -->
          <ul class="navbar-nav flex-row align-items-center ms-auto">

            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                @if(Auth::user()->role != 4)
                <a class="nav-link" href="/messenger">
                    <i class="bx bx-message-rounded-dots bx-sm"></i>
                    <span class="badge bg-danger rounded-pill badge-notifications">{{ $chat }}</span>
                  </a>
                @else
                <a class="nav-link" href="/messenger/2">
                    <i class="bx bx-message-rounded-dots bx-sm"></i>
                    <span class="badge bg-danger rounded-pill badge-notifications">{{ $chat }}</span>
                  </a>
                @endif
            </li>

              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow d-flex" href="javascript:void(0);" data-bs-toggle="dropdown">
                      <span class="me-3 mt-2 fw-medium">{{ Auth::user()->name }}</span>
                      <span class="avatar avatar-online">
                          <img src="/assets/user-logo.png" alt class="rounded-circle shadow-lg">
                      </span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                          <a class="dropdown-item" href="javascript:;" id="edit-user-profile"
                          
                          @if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                            data-name="{{ Auth::user()->name }}"
                          @endif

                          @if(Auth::user()->role == 4)
                            data-name="{{ Auth::user()->Student->lastname.' '.Auth::user()->Student->firstname.' '.Auth::user()->Student->middlename}}"
                          @endif

                            data-email="{{ Auth::user()->email }}"
                          
                          
                          >
                              <div class="d-flex">
                                  <div class="flex-shrink-0 me-3">
                                      <div class="avatar avatar-online">
                                          <img src="/assets/user-logo.png" alt class="rounded-circle shadow-lg">
                                      </div>
                                  </div>
                                  <div class="flex-grow-1">
                                      <span class="fw-medium d-block lh-1">{{ Auth::user()->name }}</span>
                                      @if(Auth::user()->role == 1)
                                          <small>Admin</small>
                                      @elseif(Auth::user()->role == 2)
                                          <small>Registrar</small>
                                      @elseif(Auth::user()->role == 3)
                                          <small>Instructor</small>
                                      @elseif(Auth::user()->role == 4)
                                          <small>Student</small>
                                      @endif
                                  </div>
                              </div>
                          </a>
                      </li>
                      <li>
                          <div class="dropdown-divider"></div>
                      </li>
                      <li>
                          <a class="dropdown-item" href="javascript:;" id="edit-user-profile" 
                          
                          @if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                            data-name="{{ Auth::user()->name }}"
                          @endif

                          @if(Auth::user()->role == 4)
                            data-name="{{ Auth::user()->Student->lastname.' '.Auth::user()->Student->firstname.' '.Auth::user()->Student->middlename}}"
                          @endif

                            data-email="{{ Auth::user()->email }}"                          
                          >
                              <i class="bx bxs-lock me-2"></i>
                              <span class="align-middle">My Account</span>
                          </a>
                      </li>
                      @if(Auth::user()->role == 2)
                      <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:;">
                            <div>
                                <i class="bx bxs-box me-2"></i>
                                <span class="align-middle">Admission Status</span>
                            </div>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" @checked(AdmissionApplication::where('id', 1)->first()->status == 1) type="checkbox" value="{{ $aes->encrypt('1') }}" id="admission-status">
                            </div>
                        </a>
                    </li>                    
                      @endif
                      @if(Auth::user()->role == 2)
                      <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:;" id="edit-sms-token" data-access-token="{{ $sms->access_token }}" data-mobile-identity="{{ $sms->mobile_identity }}">
                            <div>
                                <i class="bx bxs-chat me-2"></i>
                                <span class="align-middle">SMS API</span>
                            </div>
                        </a>
                    </li>                    
                      @endif
                      <li>
                          <a class="dropdown-item" href="javascript:;" id="sign-out">
                              <i class="bx bx-power-off me-2"></i>
                              <span class="align-middle">Log Out</span>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
      </div>
  </div>
</nav>
<!-- / Navbar -->
