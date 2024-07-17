@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Interview'], 
        ['icon' => '
          
           <lord-icon
                src="https://cdn.lordicon.com/jibstvae.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Interview |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

                <div class="row">
                    <div class="col-md-12">
                        @include('data.registrar.interview-data')
                    </div>
                </div>
          </div>
        
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
