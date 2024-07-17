@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Students'], 
        ['icon' => '
          
            <lord-icon
                src="https://cdn.lordicon.com/xzalkbkz.json"
                trigger="in"
                stroke="bold"
                style="width:22px;height:22px">
            </lord-icon>
          
        '])      

      <div class="content-wrapper">
        
          <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    
                </div>
          </div>
        
          @include('layouts.footer')
          <div class="content-backdrop fade"></div>
       </div>
    </div>
@endsection
