@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.registrar.update.enroll-student-modal')

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Enrollment'], 
        ['icon' => '
          
            <lord-icon
                src="https://cdn.lordicon.com/wuvorxbv.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Enrollment |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

                <div class="row">
                    
                    <div class="col-md-12 mb-2">
                        <div class="text-center">
                            <h5 class="text-sm"><span class="text-uppercase">{{ $course->qualification }}</span></h5>
                        </div>
                    </div>

                    <div class="col-md-3"></div>
                    <div class="col-md-6 mb-4">
                        <input type="text" class="form-control" placeholder="Search student..." id="search-enrollment" data-id="{{ $aes->encrypt($course->id) }}">
                    </div>
                    <div class="col-md-3"></div>

                    <div class="col-md-12">
                        @include('data.registrar.enrollment-data')
                    </div>
                </div>
          </div>
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
