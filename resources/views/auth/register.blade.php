@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('layouts.sidebar')
        <!-- / Menu -->

        <div class="layout-page">
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
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                    Online Admission Application
                                </a>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow d-flex" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <span class="me-3 mt-2 fw-medium">Guest</span>
                                    <span class="avatar avatar-online">
                                        <img src="/assets/user-logo.png" alt class="rounded-circle shadow-lg">
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- / Navbar -->

            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">


                    <div class="row">
                      <!-- Vertical Icons Wizard -->
                      <div class="col-md-12">
                        <p class="text-light fw-medium">Registration Form</p>
                        <div class="bs-stepper wizard-vertical vertical wizard-vertical-icons-example mt-2">
                          <div class="bs-stepper-header">
                            <div class="step" data-target="#admission-details-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class='bx bxs-info-circle text-warning'></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">1. Requirements</span>
                                  <span class="bs-stepper-subtitle">Admission Details</span>
                                </span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#learner-profile-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class="bx bx-detail"></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">2. Learner Profile</span>
                                  <span class="bs-stepper-subtitle">Setup Details</span>
                                </span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#personal-info-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class="bx bx-user"></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">3. Personal Information</span>
                                  <span class="bs-stepper-subtitle">Setup Details</span>
                                </span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#learner-classification-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class='bx bxs-objects-horizontal-center'></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">4. Learner Classification</span>
                                  <span class="bs-stepper-subtitle">Setup Details</span>
                                </span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#course-qualification-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class='bx bxs-layer' ></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">5. Course/Qualification</span>
                                  <span class="bs-stepper-subtitle">Setup Details</span>
                                </span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#working-experience-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class='bx bxs-briefcase-alt-2'></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">6. Working Experience</span>
                                  <span class="bs-stepper-subtitle">Setup Details</span>
                                </span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#privacy-consent-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class='bx bxs-check-shield' ></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">7. Privacy Consent</span>
                                  <span class="bs-stepper-subtitle">Agreement</span>
                                </span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#account-credentials-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class='bx bxs-lock' ></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">8. Account Credentials</span>
                                  <span class="bs-stepper-subtitle">Login Details</span>
                                </span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#confirmation-vertical">
                              <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                  <i class='bx bxs-message-square-check text-success' ></i>
                                </span>
                                <span class="bs-stepper-label">
                                  <span class="bs-stepper-title">9. Confirmation</span>
                                  <span class="bs-stepper-subtitle">Submit</span>
                                </span>
                              </button>
                            </div>
                            
                          </div>
                          <div class="bs-stepper-content">
                            <form id="admission-application">
                              @csrf
                              <!-- Admission Details -->
                              <div id="admission-details-vertical" class="content">
                                <div class="row">
                                  <div class="col-md-12">
                                    
                                    <div class="row">
                                      <div class="col-md-4"></div>
                                      <div class="col-md-4">
                                        <div class="app-brand demo">
                                          <img style="width: 38px; height: 38px; border-radius: 50px;" src="/assets/school-logo.png" class="me-4 mb-4 mt-2" alt="...">
                                          <a class="layout-menu-toggle align-items-center d-flex" href="javascript:void(0);">
                                            <span class="sidebar-text fw-bold fs-3">
                                                <span class="">GJTVS</span>
                                            <p style="font-size:14px;" class="fw-normal mt-1 text-secondary">Online Admission Application</p>
                                          </span>
                                        </a>
                                        </div>
                                      </div>
                                      <div class="col-md-4"></div>
                                    </div>
                                    

                                      <p>1. Admission Details and General Requirements <span class="text-primary">(<i class='bx bxs-down-arrow-circle' ></i> PLEASE READ BEFORE YOU PROCEED)</span></p>

                                      <div class="mb-2">
                                        <b>Requirements: </b>
                                      </div>
                                      <ul>
                                        <li>NSO/PSA Birth Certificate</li>
                                        <li>2 ID Pictures (1x1 picture taken within the last 6 months)</li>
                                        <li>PWD ID (if PWD)</li>
                                        <li>Form 137 (Permanent Record)</li>
                                      </ul>

                                      <h5>Data Privacy Act of 2012</h5>
                                      <p>
                                        <small class="mb-4">
                                            It is the policy of the State to protect the fundamental human right of privacy, of communication while ensuring free flow of information to promote innovation and growth. The State recognizes the vital role of information and communications technology in nation-building and its inherent obligation to ensure that personal information in information and communications systems in the government and in the private sector are secured and protected.
                                        </small>
                                    </p>
                                    
                                    <p>
                                        <b>Before you proceed, please take note of the following: </b>
                                    </p>
                                    
                                    <ol>
                                        <li>
                                            <small>
                                                During the application process, you will be required to provide personal information such as your full name, address, contact details, and other relevant data. This information is necessary to process your application and to comply with legal requirements.
                                            </small>
                                        </li>
                                        <li>
                                            <small>
                                                Your personal information will be used exclusively for the purposes of your application, enrollment, and related administrative processes. We are committed to ensuring that your data is protected and will only be accessed by authorized personnel.
                                            </small>
                                        </li>
                                        <li>
                                            <small>
                                                We are dedicated to maintaining the confidentiality, integrity, and availability of your personal data. All collected information will be stored securely and will not be shared with third parties without your explicit consent, except as required by law.
                                            </small>
                                        </li>
                                    </ol>
                                    
                                    <p>
                                      <b>Note on Email Address:</b>
                                    </p>
                                    
                                    <p>
                                        <small>
                                            Use a unique email address that you have exclusive access to as your primary account credential. Ensure it's an email you regularly monitor, as all communications and updates will be sent there.
                                        </small>
                                    </p>
                                    
                                    <p>
                                        <small>
                                            This email will also be essential for password resets and verifying your identity. Please make sure it is accurate and up-to-date.
                                        </small>
                                    </p>
                                    <hr>
                                    <p>
                                      <input type="checkbox" id="agreeTerms" name="agreeTerms">
                                      <label for="agreeTerms">
                                          <small class="text-primary">
                                              By checking this box, I confirm that I have read, understood, and agree to abide by the terms and conditions set forth by this application process.
                                          </small>
                                      </label>
                                    </p>
                                  
                                    <div class="col-12 d-flex justify-content-between">
                                      <button class="btn btn-label-secondary btn-prev" disabled>
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="d-sm-inline-block d-none">Previous</span>
                                      </button>
                                      <button type="button" class="btn btn-primary btn-next">
                                        <span class="d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Account Details -->
                              <div id="learner-profile-vertical" class="content">
                                <div class="row">
                                  <div class="col-md-12">
                                      <p>2. Learner/Manpower Profile</p>
                                  
                                  
                                      <div class="row mb-4">
                                        <div class="col-md-4 mb-4">
                                          <div><b>2.1 Name</b></div>
                                          <label for="" style="font-size: 11px">Last Name, Extension Name (Jr., Sr.)</label>
                                          <input type="text" name="lastname" class="form-control" required>
                                          
                                          <label for="" style="font-size: 11px">First Name</label>
                                          <input type="text" name="firstname" class="form-control" required>
        
                                          <label for="" style="font-size: 11px">Middle Name</label>
                                          <input type="text" name="middlename" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                          <div><b>2.2 Complete Permanent Mailing Address</b></div>
                                          <label for="" style="font-size: 11px">Region</label>
                                          @include('auth.address.region')
        
                                          <label for="" style="font-size: 11px">Province</label>
                                          @include('auth.address.province')
        
                                          <label for="" style="font-size: 11px">Municipal</label>
                                          @include('auth.address.municipal')
        
                                          <label for="" style="font-size: 11px">Barangay</label>
                                          @include('auth.address.barangay')
                                        </div>
                                        <div class="col-md-4">
                                          <label for="" style="font-size: 11px">District</label>
                                          <input type="text" name="district" class="form-control" required>
        
                                          <label for="" style="font-size: 11px">Number, Street</label>
                                          <input type="text" name="street" class="form-control" required>
        
                                          <label for="" style="font-size: 11px">Email Address/Facebook Account</label>
                                          <input type="text" name="account" class="form-control" required>
        
                                          <label for="" style="font-size: 11px">Contact Number</label>
                                          <input type="number" name="phone" class="form-control" required>
        
                                          <label for="" style="font-size: 11px">Nationality</label>
                                          <input type="text" name="nationality" class="form-control" required>
                                        </div>
                                      </div>
                                      
                                      <div class="col-12 d-flex justify-content-between">
                                        <button type="button" class="btn btn-primary btn-prev">
                                          <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                          <span class="d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next">
                                          <span class="d-sm-inline-block d-none me-sm-1">Next</span>
                                          <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                        </button>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Personal Info -->
                              <div id="personal-info-vertical" class="content">

                                <div class="row">
                                  <div class="col-md-12">
                                      <p>3. Personal Information</p>

                                        <div class="row mb-4">
                                          <div class="col-md-6 mb-4">
                                            <div><b>3.1 Sex</b></div>
                                            <div>
                                              <input type="radio" value="1" name="sex">
                                              <label for="" style="font-size: 13px">Male</label>
                                            </div>
                                            <div>
                                              <input type="radio" value="2" name="sex">
                                              <label for="" style="font-size: 13px">Female</label>
                                            </div>
                                          </div>
                                          <div class="col-md-6 mb-4">
                                            <div><b>3.2 Civil Status</b></div>
                                            <div>
                                              <input type="radio" value="1" name="civilStatus">
                                              <label for="" style="font-size: 13px">Single</label>
                                            </div>
                                            <div>
                                              <input type="radio" value="2" name="civilStatus">
                                              <label for="" style="font-size: 13px">Married</label>
                                            </div>
                                            <div>
                                              <input type="radio" value="3" name="civilStatus">
                                              <label for="" style="font-size: 13px">Separated/Divorced/Annulled</label>
                                            </div>
                                            <div>
                                              <input type="radio" value="4" name="civilStatus">
                                              <label for="" style="font-size: 13px">Widower</label>
                                            </div>
                                            <div>
                                              <input type="radio" value="5" name="civilStatus">
                                              <label for="" style="font-size: 13px">Common Law/Live In</label>
                                            </div>
                                          </div>
                                          <div class="col-md-6 mb-4">
                                            <div><b>3.3 Employment (before the training)</b></div>
                                            <div class="row">
                                              <div class="col-md-6 mb-4">
                                                <p class="mb-2">Employment Status</p>
                                                <div>
                                                  <input type="radio" value="1" name="employmentStatus">
                                                  <label for="" style="font-size: 13px">Wage-Employed</label>
                                                </div>
                                                <div>
                                                  <input type="radio" value="2" name="employmentStatus">
                                                  <label for="" style="font-size: 13px">Underemployed</label>
                                                </div>
                                                <div>
                                                  <input type="radio" value="3" name="employmentStatus">
                                                  <label for="" style="font-size: 13px">Self-Employed</label>
                                                </div>
                                                <div>
                                                  <input type="radio" value="4" name="employmentStatus">
                                                  <label for="" style="font-size: 13px">Unemployed</label>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div id="show-employment-type" style="display: none">
                                                  <p class="mb-2">Employment Type</p>
                                                  <small style="font-size: 10px">(if Wage-employed or Underemployed)</small>
                                                  
                                                  @php
                                                    $type = [];
                                                    $type[0] = 'None';
                                                    $type[1] = 'Casual';
                                                    $type[2] = 'Probationary';
                                                    $type[3] = 'Contractual';
                                                    $type[4] = 'Regular';
                                                    $type[5] = 'Job Order';
                                                    $type[6] = 'Permanent';
                                                    $type[7] = 'Temporary';
                                                  @endphp
  
                                                  @for($i = 0; $i < 8; $i++)
                                                  <div>
                                                    <input type="radio" value="{{ $i + 1 }}" name="employmentType">
                                                    <label for="" style="font-size: 13px">{{ $type[$i] }}</label>
                                                  </div>
                                                  @endfor
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6 mb-4">
                                            <div><b>3.4 Birthdate</b></div>
                                            <div class="row mb-2">
                                              <div class="col-md-6">
                                                <label for="" style="font-size: 11px">Date</label>
                                                <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                                              </div>
                                              <div class="col-md-6">
                                                <label for="" style="font-size: 11px">Age</label>
                                                <input type="text" name="age" id="age" class="form-control" readonly>
                                              </div>
                                            </div>
                                            <div><b>3.5 Birthplace</b></div>
                                            <div class="row">
                                              <div class="col-md-12">
                                                <label for="" style="font-size: 11px">Region</label>
                                                @include('auth.birthplace.region')
                                              </div>
                                              <div class="col-md-6">
                                                <label for="" style="font-size: 11px">Province</label>
                                                @include('auth.birthplace.province')
                                              </div>
                                              <div class="col-md-6">
                                                <label for="" style="font-size: 11px">City/Municipality</label>
                                                @include('auth.birthplace.municipal')
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-8 mb-4">
                                            <div><b>3.6 Educational Attainment Before the Training (Trainee)</b></div>
                                              @php
                                                $educ = [];
                                                $educ[0] = 'No Grade Completed';
                                                $educ[1] = 'Elementary Undergraduate';
                                                $educ[2] = 'Elementary Graduate';
                                                $educ[3] = 'High School Undergraduate';
                                                $educ[4] = 'High School Graduate';
                                                $educ[5] = 'Junior High (K-12)';
                                                $educ[6] = 'Senior High (K-12)';
                                                $educ[7] = 'Post Secondary Non-Tertiary/Technical Vocational Course Undergraduate';
                                                $educ[8] = 'Post Secondary Non-Tertiary/Technical Vocational Course Graduate';
                                                $educ[9] = 'College Undergraduate';
                                                $educ[10] = 'College Graduate';
                                                $educ[11] = 'Masteral';
                                                $educ[12] = 'Doctorate';
                                              @endphp

                                              @for($i = 0; $i < 13; $i++)
                                              <div>
                                                <input type="radio" value="{{ $i + 1 }}" name="education">
                                                <label for="" style="font-size: 13px">{!! $educ[$i] !!}</label>
                                              </div>
                                              @endfor
                                          </div>
                                          <div class="col-md-4 mb-4">
                                            <div><b>3.7 Parent/Guardian</b></div>
                                            <label for="" style="font-size: 11px">Name</label>
                                            <input type="text" name="parent" class="form-control" required>

                                            <label for="" style="font-size: 11px">Parent's Contact Number</label>
                                            <input type="text" name="parentContact" class="form-control" required>

                                            <label for="" style="font-size: 11px">Complete Permanent Mailing Address</label>
                                            <textarea name="parentAddress" id="" cols="30" rows="5" class="form-control" required></textarea>
                                          </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                          <button type="button" class="btn btn-primary btn-prev">
                                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                            <span class="d-sm-inline-block d-none">Previous</span>
                                          </button>
                                          <button type="button" class="btn btn-primary btn-next">
                                            <span class="d-sm-inline-block d-none me-sm-1">Next</span>
                                            <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                          </button>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              
                              <!-- Learner CLassification -->
                              <div id="learner-classification-vertical" class="content">
                                
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>4. Learner/Trainee/Student (Clients) Classification</p>
                                    <div class="row mb-4">
                                      <div class="col-md-6 mb-4">
                                            @php
                                                $classOne = [];
                                                $classOne[0] = '4Ps Beneficiary';
                                                $classOne[1] = 'Displaced Workers';
                                                $classOne[2] = 'Family Members of AFP and PNP Wounded in-Action';
                                                $classOne[3] = 'Industry Workers';
                                                $classOne[4] = 'Out-of-School-Youth';
                                                $classOne[5] = 'Rebel Returnees/Decommissioned Combatants';
                                                $classOne[6] = 'TESDA Alumni';
                                                $classOne[7] = 'Victim of Natural Disasters and Calamities';
                                                
                                              @endphp

                                              @for($i = 0; $i < 8; $i++)
                                              <div>
                                                <input type="checkbox" value="{{ $i + 1 }}" name="classOne[]">
                                                <label for="" style="font-size: 13px">{!! $classOne[$i] !!}</label>
                                              </div>
                                              @endfor
                                      </div>
                                      <div class="col-md-6 mb-4">
                                            @php
                                                $classTwo = [];
                                                $classTwo[8] = 'Agrarian Reform Beneficiary';
                                                $classTwo[9] = 'Drug Dependents Surrenderees/Surrenderers';
                                                $classTwo[10] = 'Farmers and Fisherman';
                                                $classTwo[11] = 'Inmates and Detainees';
                                                $classTwo[12] = 'Overseas Filipino Workers (OFW) Dependent';
                                                $classTwo[13] = 'Returning/Repatriated Overseas Filipino Workers (OFW)';
                                                $classTwo[14] = 'TVET Trainers';
                                                $classTwo[15] = 'Wounded-in-Action AFP & PNP Personnel';
                                                
                                              @endphp

                                              @for($i = 8; $i < 16; $i++)
                                              <div>
                                                <input type="checkbox" value="{{ $i + 1 }}" name="classTwo[]">
                                                <label for="" style="font-size: 13px">{!! $classTwo[$i] !!}</label>
                                              </div>
                                              @endfor
                                      </div>
                                      <div class="col-md-6 mb-4">
                                            @php
                                                $classThree = [];
                                                $classThree[16] = 'Balik Probinsya';
                                                $classThree[17] = 'Family Members of AFP and PNP Killed-in-Action';
                                                $classThree[18] = 'Indigenous People & Cultural Communities';
                                                $classThree[19] = 'MILF Beneficiary';
                                                $classThree[20] = 'RCEF-RESP';
                                                $classThree[21] = 'Student';
                                                $classThree[22] = 'Uniformed Personnel';
                                                $classThree[23] = 'Others';
                                                
                                              @endphp

                                              @for($i = 16; $i < 24; $i++)
                                              <div>
                                                <input type="checkbox" value="{{ $i + 1 }}" name="classThree[]">
                                                <label for="" style="font-size: 13px">{!! $classThree[$i] !!}</label>
                                              </div>
                                              @endfor

                                              <label for="" style="font-size: 11px"> if Others (pls specify)</label>
                                              <input type="text" name="others" class="form-control">
                                      </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                      <button type="button" class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="d-sm-inline-block d-none">Previous</span>
                                      </button>
                                      <button type="button" class="btn btn-primary btn-next">
                                        <span class="d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Course/Qualification -->
                              <div id="course-qualification-vertical" class="content">
                                
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>5. Name of Course/Qualification</p>
                                    <div class="row mb-4">
                                      <div class="col-md-12 mb-4">
                                        <label for="" style="font-size: 11px">Course</label>
                                        <select name="course" id="" class="form-select" required>
                                            <option value="">Select Course...</option>
                                            @foreach ($courses as $cor)
                                              <option value="{{ $aes->encrypt($cor->id) }}">{{ $cor->qualification }}</option>
                                            @endforeach
                                        </select>
                                      </div>

                                      <div class="col-md-12 mb-4">
                                        <label for="" style="font-size: 13px">If Scholar, What Type of Scholarship Package (TWSP, PESFA, STEP, others)?</label>
                                        <input type="text" name="scholarship" class="form-control">
                                      </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                      <button type="button" class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="d-sm-inline-block d-none">Previous</span>
                                      </button>
                                      <button type="button" class="btn btn-primary btn-next">
                                        <span class="d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Working Experience -->
                              <div id="working-experience-vertical" class="content">
                                
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>6. Working Experience</p>
                                    
                                    <div class="row mb-4">
                                      @for($i = 0; $i < 3; $i++)
                                      <div class="col-md-4 mb-4">
                                        <hr class="my-2">
                                        <label for="" style="font-size: 11px">Name of Company</label>
                                        <input type="text" name="company[]" class="form-control">

                                        <label for="" style="font-size: 11px">Position</label>
                                        <input type="text" name="position[]" class="form-control">

                                        <label for="" style="font-size: 11px">Inclusive Date From</label>
                                        <input type="date" name="dateFrom[]" class="form-control">

                                        <label for="" style="font-size: 11px">Inclusive Date To</label>
                                        <input type="date" name="dateTo[]" class="form-control">

                                        <label for="" style="font-size: 11px">Salary</label>
                                        <input type="number" step="any" min="0" name="salary[]" class="form-control">

                                        <label for="" style="font-size: 11px">Status</label>
                                        <input type="text" name="status[]" class="form-control">
                                      </div>
                                      @endfor
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                      <button type="button" class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="d-sm-inline-block d-none">Previous</span>
                                      </button>
                                      <button type="button" class="btn btn-primary btn-next">
                                        <span class="d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Privacy Consent -->
                              <div id="privacy-consent-vertical" class="content">
                                
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>7. Privacy Consent and Disclaimer</p>
                                    
                                    <div class="row mb-4">
                                      <div class="col-md-12">
                                          <p>
                                            I hereby attest that I have read and understood the Privacy Notice of TESDA through its website 
                                            <a href="https://www.tesda.gov.ph" target="_blank" class="text-primary text-decoration-underline">https://www.tesda.gov.ph</a> 
                                            and thereby giving my consent in the processing of my personal information indicated in this Learners Profile. The processing
                                            includes scholarships, employment, survey, and all other related TESDA programs that may be beneficial to my qualifications.
                                          </p>

                                          <div>
                                            <input type="radio" name="consent" value="Yes" required>
                                            <label for="">Agree</label>
                                          </div>
                                        
                                          <div>
                                            <input type="radio" name="consent" value="No" required>
                                            <label for="">Disagree</label>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                      <button type="button" class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="d-sm-inline-block d-none">Previous</span>
                                      </button>
                                      <button type="button" class="btn btn-primary btn-next">
                                        <span class="d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Account Credentials -->
                              <div id="account-credentials-vertical" class="content">
                                
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>8. Account Credentials for Log in</p>
                                    
                                    <div class="mb-2">
                                      <small class="">This account will be your permanent access to all your information within the system. Please ensure you remember your credentials and keep them secure.</small>
                                    </div>

                                    <div class="row mb-4">
                                      <div class="col-md-12">
                                        <div class="mb-3">
                                          <label for="email" class="form-label text-capitalize">Email or Username</label>
                                          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="" required>
                                        </div>

                                        <label class="form-label text-capitalize" for="password">Password</label>
                                        <div class="input-group input-group-merge">
                                          <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required/>
                                          <span class="input-group-text cursor-pointer" id="show-password"><i class="far fa-eye-slash"></i></span>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                      <button type="button" class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="d-sm-inline-block d-none">Previous</span>
                                      </button>
                                      <button type="button" class="btn btn-primary btn-next">
                                        <span class="d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Confirmation -->
                              <div id="confirmation-vertical" class="content">
                                
                                <div class="row">
                                  <div class="col-md-12">
                                    <p>8. Confirmation and Notice</p>
                                    
                                    <div class="row mb-4">
                                      <div class="col-md-12">
                                        <div class="mb-2"><b>IMPORTANT NOTICE:</b></div>
                                          <p>
                                            The registrar's office will handle the applicant's signature and ID placement on the registration form. After submitting the form online, you can log in with your account credentials to download a soft copy. <b>Please print the form</b>, attach the required documents, and submit them to the registrar's office.
                                          </p>
                                      </div>
                                      <p class="fw-bolder">Sample Printed Form</p>
                                      <div class="col-md-6 mb-4">
                                        <img src="{{ asset('storage/forms/page-1.jpg') }}" alt="" class="img-fluid" style="width: 80%; height: auto;">
                                      </div>
                                      <div class="col-md-6 mb-4">
                                        <img src="{{ asset('storage/forms/page-2.jpg') }}" alt="" class="img-fluid" style="width: 80%; height: auto;">
                                      </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                      <button type="button" class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="d-sm-inline-block d-none">Previous</span>
                                      </button>
                                      <button class="btn btn-success">Submit</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- /Vertical Icons Wizard -->
                    </div>
                </div>

                @include('layouts.footer')
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
</div>
@endsection
