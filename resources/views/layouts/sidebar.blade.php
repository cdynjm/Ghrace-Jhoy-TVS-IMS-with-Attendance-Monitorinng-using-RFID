@php
  use Illuminate\Support\Str;
  use App\Http\Controllers\AESCipher;
  use App\Models\LearnersProfile;
  $status = LearnersProfile::where('admission_status', 1)->get();
  $aes = new AESCipher();
@endphp

<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme shadow-sm" style="position: fixed; z-index: 10;">

  
    <div class="app-brand demo mt-4 p-3">
      <img style="width: 55px; height: auto; border-radius: 50px;" src="/assets/school-logo.png" class="me-4 mb-4 mt-2" alt="...">
      <a class="layout-menu-toggle align-items-center d-flex" href="javascript:void(0);">
        <span class="sidebar-text fw-bold fs-3">
            <span class="">GJTVSI</span>
        <p style="font-size:10px;" class="fw-normal mt-2 text-secondary">Ghrace Jhoy Technical Vocational School, Inc.</p>
      </span>
    </a>
    </div>
    
    <ul class="menu-inner">
      @if(Auth::check())

      @if(Auth::user()->role == 1)

      <li class="menu-header small text-uppercase"><span class="menu-header-text">General</span></li>

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

      <li class="menu-item {{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.instructors') }}" class="menu-link {{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/wzrwaorf.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
        </span>
          <div>Instructors</div>
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

      <li class="menu-item {{ Route::currentRouteName() == 'admin.schedule' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.schedule') }}" class="menu-link {{ Route::currentRouteName() == 'admin.schedule' ? 'active' : '' }}">
          <span class="me-2">
              <lord-icon
                  src="https://cdn.lordicon.com/qvyppzqz.json"
                  trigger="in"
                  stroke="bold"
                  style="width:22px;height:22px">
              </lord-icon>
          </span>
          <div>Schedule</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'admin.graduates' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.graduates') }}" class="menu-link {{ Route::currentRouteName() == 'admin.graduates' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/qmsejndz.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Graduates</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'admin.undergraduates' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.undergraduates') }}" class="menu-link {{ Route::currentRouteName() == 'admin.undergraduates' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/bjbmvfnr.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Students <small style="font-size: 11px">(Undergraduates)</small></div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'admin.attendance' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('admin.attendance') }}" class="menu-link {{ Route::currentRouteName() == 'admin.attendance' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/wzwygmng.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Attendance</div>
        </a>
      </li>

      @endif

      @if(Auth::user()->role == 2)

      <li class="menu-header small text-uppercase"><span class="menu-header-text">General</span></li>

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

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.instructors' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.instructors') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.instructors' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/wzrwaorf.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
        </span>
          <div>Instructors</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.courses' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.courses') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.courses' ? 'active' : '' }}">
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

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.schedule' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.schedule') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.schedule' ? 'active' : '' }}">
          <span class="me-2">
              <lord-icon
                  src="https://cdn.lordicon.com/qvyppzqz.json"
                  trigger="in"
                  stroke="bold"
                  style="width:22px;height:22px">
              </lord-icon>
          </span>
          <div>Schedule</div>
        </a>
      </li>
  
      <li class="menu-item {{ in_array(Route::currentRouteName(), ['registrar.unscheduled', 'registrar.exam', 'registrar.interview', 'registrar.final-result']) ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <span class="me-2">
                <lord-icon
                    src="https://cdn.lordicon.com/kpxbczav.json"
                    trigger="in"
                    stroke="bold"
                    style="width:22px;height:22px">
                </lord-icon>
            </span>
            <div>Admission</div>
            <div class="badge bg-danger rounded-pill ms-auto">
            {{ 
              $status->where('status', 2)->where('failed', null)->count() +
              $status->where('status', 3)->where('failed', null)->count() +
              $status->where('failed', null)->whereIn('status', [4, 5])->count() +
              $status->where('status', 6)->where('failed', null)->count()

            }}
            </div>
        </a>
    
        <ul class="menu-sub">
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
                    <div>Pending
                        @if(!empty($status->where('status', 2)->where('failed', null)->count()))
                        <span class="ms-2 badge rounded-pill bg-danger">
                            {{ $status->where('status', 2)->where('failed', null)->count() }}
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
                        @if(!empty($status->where('status', 3)->where('failed', null)->count()))
                        <span class="ms-2 badge rounded-pill bg-danger">
                            {{ $status->where('status', 3)->where('failed', null)->count() }}
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
                        @if(!empty($status->where('failed', null)->whereIn('status', [4, 5])->count()))
                        <span class="ms-2 badge rounded-pill bg-danger">
                            {{ $status->where('failed', null)->whereIn('status', [4, 5])->count() }}
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
                        @if(!empty($status->where('status', 6)->where('failed', null)->count()))
                        <span class="ms-2 badge rounded-pill bg-danger">
                            {{ $status->where('status', 6)->where('failed', null)->count() }}
                        </span>
                        @endif
                    </div>
                </a>
            </li>
        </ul>
    </li>
    

      <li class="menu-header small text-uppercase mt-0"><span class="menu-header-text">Academic Records</span></li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.enroll-grades' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.enroll-grades') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.enroll-grades' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/wzrwaorf.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Enrollment</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.grades-course' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.grades-course') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.grades-course' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/fcyboqbm.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Grades</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.graduates' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.graduates') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.graduates' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/qmsejndz.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Graduates</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.undergraduates' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.undergraduates') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.undergraduates' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/bjbmvfnr.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Students <small style="font-size: 11px">(Undergraduates)</small></div>
        </a>
      </li>

      <li class="menu-header small text-uppercase mt-0"><span class="menu-header-text">Attendance</span></li>

      <li class="menu-item {{ Route::currentRouteName() == 'AdminOrRegistrar.rfid-attendance' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('AdminOrRegistrar.rfid-attendance') }}" class="menu-link {{ Route::currentRouteName() == 'AdminOrRegistrar.rfid-attendance' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/eqnxbkyy.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Scan RFID</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'registrar.attendance' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.attendance') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.attendance' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/wzwygmng.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Attendance</div>
        </a>
      </li>


      <li class="menu-item mb-4 {{ Route::currentRouteName() == 'registrar.rfid-information' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('registrar.rfid-information') }}" class="menu-link {{ Route::currentRouteName() == 'registrar.rfid-information' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/sobzmbzh.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>RFID Information</div>
        </a>
      </li>

      @endif

      @if(Auth::user()->role == 3)

      <li class="menu-header small text-uppercase"><span class="menu-header-text">General</span></li>

      <li class="menu-item {{ Route::currentRouteName() == 'trainer.dashboard' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('trainer.dashboard') }}" class="menu-link {{ Route::currentRouteName() == 'trainer.dashboard' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
              src="https://cdn.lordicon.com/qvyppzqz.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Schedule</div>
        </a>
      </li>

      <li class="menu-item mb-4 {{ Route::currentRouteName() == 'trainer.grades' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('trainer.grades') }}" class="menu-link {{ Route::currentRouteName() == 'trainer.grades' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
              src="https://cdn.lordicon.com/fcyboqbm.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Grades</div>
        </a>
      </li>

      @endif

      @if(Auth::user()->role == 4)

      <li class="menu-header small text-uppercase"><span class="menu-header-text">General</span></li>

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

      <li class="menu-item {{ Route::currentRouteName() == 'student.schedule' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('student.schedule') }}" class="menu-link {{ Route::currentRouteName() == 'student.schedule' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
              src="https://cdn.lordicon.com/qvyppzqz.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Schedule</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'student.grades' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('student.grades') }}" class="menu-link {{ Route::currentRouteName() == 'student.grades' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
              src="https://cdn.lordicon.com/abwrkdvl.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Grades</div>
        </a>
      </li>

      <li class="menu-item {{ Route::currentRouteName() == 'student.attendance' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('student.attendance') }}" class="menu-link {{ Route::currentRouteName() == 'student.attendance' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/wzwygmng.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Attendance</div>
        </a>
      </li>

      <li class="menu-item mb-4 {{ Route::currentRouteName() == 'student.courses-info' ? 'active' : '' }}">
        <a wire:navigate href="{{ route('student.courses-info', ['id' => $aes->encrypt(Auth::user()->Student->LearnersCourse->course)] ) }}" class="menu-link {{ Route::currentRouteName() == 'student.courses-info' ? 'active' : '' }}">
          <span class="me-2">
            <lord-icon
                src="https://cdn.lordicon.com/tsrgicte.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          </span>
          <div>Prospectus</div>
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
                      src="https://cdn.lordicon.com/kpxbczav.json"
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