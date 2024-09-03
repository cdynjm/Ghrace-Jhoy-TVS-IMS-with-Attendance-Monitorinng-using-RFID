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
                        <a wire:navigate href="{{ route('registrar.grades', ['id' => $aes->encrypt2($student->LearnersCourse->course)]) }}" class="fw-bold text-primary">Go Back |</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);" class="fw-bold">Grades |</a>
                    </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

            <div class="row">

                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <a class="nav-link hide-arrow d-flex" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <span class="avatar me-2">
                                    <img src="/assets/user-logo.png" alt class="rounded-circle shadow-lg">
                                </span>
                                <span class="me-3 mt-2 fw-medium"> {{ $student->lastname }} {{ $student->firstname }} {{ $student->middlename }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                @include('data.registrar.edit-grades-data')
            </div>
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
