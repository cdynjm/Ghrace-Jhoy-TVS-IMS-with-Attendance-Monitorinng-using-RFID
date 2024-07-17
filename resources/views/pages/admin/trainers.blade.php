@extends('app')

@section('content')
    <div class="layout-page">
        @include('layouts.navbar', ['page' => 'Trainers'], 
        ['icon' => '
          
            <lord-icon
                src="https://cdn.lordicon.com/wzrwaorf.json"
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
