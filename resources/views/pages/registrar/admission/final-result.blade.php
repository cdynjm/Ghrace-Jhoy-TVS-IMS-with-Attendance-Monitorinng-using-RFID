@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Final Result'], 
        ['icon' => '
          
           <lord-icon
                src="https://cdn.lordicon.com/rahouxil.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Final Result |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" placeholder="Search..." id="search-final-result">
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h6 class="text-sm">Evaluation</h6>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary shadow text-white me-2" id="admission-passed"><i class="fas fa-check me-1"></i> Passed</button>
                                        <button class="btn btn-sm btn-danger shadow text-white" id="failed-admission"><i class="fas fa-times me-1"></i> Failed</button>    
                                    </div>
                                </div>
                                <input type="checkbox" class="me-2" id="masterCheckbox-final">
                                <label for=""><small>Select All</small></label>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @include('data.registrar.final-result-data')
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
