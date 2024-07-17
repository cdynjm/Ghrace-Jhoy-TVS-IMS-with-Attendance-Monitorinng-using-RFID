@php
  use App\Models\LearnersProfile;
  $status = LearnersProfile::where('admission_status', 1)->get();
@endphp

<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme shadow-sm" style="position: fixed; z-index: 10;">

  
    <div class="app-brand demo mt-4">
      <img style="width: 38px; height: 38px; border-radius: 50px;" src="/assets/school-logo.png" class="me-4 mb-4 mt-2" alt="...">
      <a class="layout-menu-toggle align-items-center d-flex" href="javascript:void(0);">
        <span class="sidebar-text fw-bold fs-3">
            <span class="">GJTVS</span>
        <p style="font-size:10px;" class="fw-normal mt-1 text-secondary">Information Management System</p>
      </span>
    </a>
    </div>
    
    <ul class="menu-inner">
      @if(Auth::check())

      @if(Auth::user()->role == 1)

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Pages</span></li>

      <li class="menu-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.dashboard') }}" class="menu-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
              src="https://cdn.lordicon.com/xirobkro.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Dashboard</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'admin.trainers' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.trainers') }}" class="menu-link {{ Route::currentRouteName() == 'admin.trainers' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/wzrwaorf.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
        </span>
          <div>Trainers</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'admin.courses' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.courses') }}" class="menu-link {{ Route::currentRouteName() == 'admin.courses' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/uecgmesg.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Courses</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'admin.students' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.students') }}" class="menu-link {{ Route::currentRouteName() == 'admin.students' ? 'active' : '' }}">
          <span class="me-2">
              <lord-icon
                  src="https://cdn.lordicon.com/xzalkbkz.json"
                  trigger="in"
                  stroke="bold"
                  style="width:22px;height:22px">
              </lord-icon>
          </span>
          <div>Students</div>
        </a>
      </li>

      @endif

      @if(Auth::user()->role == 2)

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Pages</span></li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.dashboard' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.dashboard') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.dashboard' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
              src="https://cdn.lordicon.com/xirobkro.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Dashboard</div>
        </a>
      </li>


      <li class="menu-header small text-uppercase"><span class="menu-header-text">Admission</span></li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.unscheduled' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.unscheduled') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.unscheduled' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/qvyppzqz.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Unscheduled

            @if(!empty($status->where('status', 2)->count()))
            <span class="ms-2 badge rounded-pill bg-danger">
              {{ $status->where('status', 2)->count() }}
            </span>
            @endif

          </div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.exam' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.exam') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.exam' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/ghhwiltn.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Exam

            @if(!empty($status->where('status', 3)->count()))
            <span class="ms-2 badge rounded-pill bg-danger">
              {{ $status->where('status', 3)->count() }}
            </span>
            @endif

          </div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.interview' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.interview') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.interview' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/jibstvae.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Interview

            @if(!empty($status->where('status', 4)->count()))
            <span class="ms-2 badge rounded-pill bg-danger">
              {{ $status->where('status', 4)->count() }}
            </span>
            @endif

          </div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.final-result' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.final-result') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.final-result' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/rahouxil.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Final Result

            @if(!empty($status->where('status', 5)->count()))
            <span class="ms-2 badge rounded-pill bg-danger">
              {{ $status->where('status', 5)->count() }}
            </span>
            @endif            

          </div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Enrollment</span></li>

      @endif

      @if(Auth::user()->role == 4)

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Pages</span></li>

      <li class="menu-item {{ Route::currentRouteName() == 'student.dashboard' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('student.dashboard') }}" class="menu-link {{ Route::currentRouteName() == 'student.dashboard' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
              src="https://cdn.lordicon.com/xirobkro.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Dashboard</div>
        </a>
      </li>

      @endif

      @else
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Guest</span>
      </li>
      <li class="menu-item {{ Route::currentRouteName() == 'register' ? 'active' : '' }}">
          <a wire:navigate href="{{ route('register') }}" class="menu-link {{ Route::currentRouteName() == 'register' ? 'active' : '' }}">
              <span class="me-2">
                  <lord-icon
                      src="https://cdn.lordicon.com/wuvorxbv.json"
                      trigger="in"
                      stroke="bold"
                      style="width:22px;height:22px">
                  </lord-icon>
              </span>
              <div>Admission</div>
          </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'login' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('login') }}" class="menu-link {{ Route::currentRouteName() == 'login' ? 'active' : '' }}">
            <span class="me-2">
              <lord-icon
                  src="https://cdn.lordicon.com/bgebyztw.json"
                  trigger="in"
                  stroke="bold"
                  style="width:22px;height:22px">
              </lord-icon>
            </span>
            <div>Log In</div>
        </a>
      </li>
      @endif
    </ul>
  </aside>
  <!-- / Menu -->