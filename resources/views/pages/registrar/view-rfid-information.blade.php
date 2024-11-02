@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.registrar.update.edit-student-information')

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'RFID Information'], 
        ['icon' => '
          
            <lord-icon
                src="https://cdn.lordicon.com/sobzmbzh.json"
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
                    <a href="javascript:void(0);" class="fw-bold">RFID Information |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" placeholder="Search..." id="search-rfid-information" data-id="{{ $aes->encrypt($course->id) }}">
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h6 class="text-sm">{{ $course->qualification }}</h6>
                                    </div>
                                    <div class="d-flex">
                                        <small class="me-2 mt-1">Total: </small><h3>{{ $undergraduates->flatten()->count() }}</h3>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                   @include('data.registrar.view-rfid-information-data')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
          
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
