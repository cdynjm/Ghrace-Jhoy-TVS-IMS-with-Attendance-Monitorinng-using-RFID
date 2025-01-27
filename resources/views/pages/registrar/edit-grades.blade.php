@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.registrar.update.edit-grades-modal')

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Grades'], 
        ['icon' => '
          
            <lord-icon
              src="https://cdn.lordicon.com/abwrkdvl.json"
              trigger="in"
              stroke="bold"
              style="width:22px;height:22px">
            </lord-icon>
          
        '])
      
      <div class="content-wrapper">
        
          <div class="container-xxl flex-grow-1 container-p-y">

            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);" class="fw-bold">Grades |</a>
                    </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

            <div class="row">

                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <!-- Left side with user info -->
                            <div class="d-flex align-items-center">
                                <a class="nav-link hide-arrow d-flex" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <span class="avatar me-2">
                                        <img src="/assets/user-logo.png" alt class="rounded-circle shadow-lg">
                                    </span>
                                    <span class="fw-medium mt-2 ms-1">{{ $student->lastname }} {{ $student->firstname }} {{ $student->middlename }}</span>
                                </a>
                            </div>
                        
                            <!-- Right side with action buttons -->
                            @include('data.registrar.enroll-graduate-button')
                        </div>
                        
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    
                    <select name="yearSemester" id="search-year-semester" class="form-select" required data-id="{{ $id }}">
                        <option value="">Select Year and Semester...</option>
                        @foreach ($courseInfo as $ci)
                            <option value="{{ $aes->encrypt($ci->id) }}">{{ $ci->yearLevel }} - {{ $ci->semester }}</option>
                        @endforeach
                    </select>
                </div>

                @include('data.registrar.edit-grades-data')
            </div>
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
