@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();

@endphp

@extends('modals.admin.create.course-modal')
@extends('modals.admin.update.course-modal')

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Graduates'], 
        ['icon' => '
          
            <lord-icon
                src="https://cdn.lordicon.com/qmsejndz.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Categories |</a>
                  </li>
                  <li class="breadcrumb-item">Graduates</li>
                </ol>
            </nav>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h6 class="text-sm">Select Program to View Records</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @include('data.registrar.graduates-data')
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
