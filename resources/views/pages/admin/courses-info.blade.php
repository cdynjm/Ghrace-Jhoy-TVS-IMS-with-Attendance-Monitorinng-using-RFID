@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.admin.create.course-info-modal')
@extends('modals.admin.update.course-info-modal')

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Courses Information'], 
        ['icon' => '
          
            <lord-icon
                src="https://cdn.lordicon.com/uecgmesg.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Prospectus |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" placeholder="Search Subjects..." id="search-course-info" data-id="{{ $aes->encrypt($course->id) }}">
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h6 class="text-sm">{{ $course->qualification }}</h6>
                                    </div>
                                    @if(Auth::user()->role == 2)
                                    <button class="btn btn-sm btn-primary shadow text-white" id="add-course-info" data-id="{{ $aes->encrypt($course->id) }}">+ Add</button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @include('data.admin.course-info-data')
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
