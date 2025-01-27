@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Grades & Attendances'], 
        ['icon' => '
          
            <lord-icon
              src="https://cdn.lordicon.com/fcyboqbm.json"
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
                    <a href="javascript:void(0);" class="fw-bold">Grades & Attendances |</a>
                  </li>
                  <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>

            <div class="row">
                <form id="search-grades-instructor">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <select name="course" id="course-change" class="form-select" required>
                                <option value="">Select Major</option>
                                @foreach ($courses as $cr)
                                    <option value="{{ $aes->encrypt($cr->id) }}">{{ $cr->qualification }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <select name="schoolYear" id="school-year" class="form-select" required>
                                <option value="">Select Academic Year</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <select name="yearSemester" id="year-semester" class="form-select" required>
                                <option value="">Select Year & Semester</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <button class="btn btn-success"><i class='bx bxs-search-alt-2 text-lg'></i></button>
                        </div>
                    </div>
                </form>

                
                @include('data.trainer.grades-data')
            
              

            </div>

        </div>
        
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
