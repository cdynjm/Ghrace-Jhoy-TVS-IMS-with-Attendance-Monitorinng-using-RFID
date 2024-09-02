<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="token" content="{{ Session::get('token') }}">
    <title>GJTVS - IMS</title>

    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://1.envato.market/frest_admin">
    
    <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      '//www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-5J3LMKC');</script>
    <!-- End Google Tag Manager -->
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/school-logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" /> 
    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/spinkit/spinkit.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />

    <!-- Vendor -->
    <link rel="stylesheet" href="/assets/vendor/libs/%40form-validation/umd/styles/index.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css' data-navigate-once>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" data-navigate-once></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" data-navigate-once></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js" data-navigate-once></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" data-navigate-once></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js" data-navigate-once></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous" data-navigate-once></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" data-navigate-once></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js?{{ \Str::random(10) }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->

    @if(Auth::check())
    <script src="{{ asset('assets/javascript/signout.js?id=04062024') }}" data-navigate-once></script>
      @if(Auth::user()->role == 1)
        <script src="{{ asset('assets/javascript/admin.js?id=04062024') }}" data-navigate-once></script>
      @endif
      @if(Auth::user()->role == 2)
        <script src="{{ asset('assets/javascript/registrar.js?id=05062024') }}" data-navigate-once></script>
      @endif
      @if(Auth::user()->role == 4)
        <script src="{{ asset('assets/javascript/student.js?id=109062024') }}" data-navigate-once></script>
      @endif
    @else
    <script src="{{ asset('assets/javascript/signin.js?id=04062024') }}" data-navigate-once></script>
    @endif

    <script src="{{ asset('assets/javascript/main.js?cache=04062024') }}" data-navigate-once></script>
    <script src="{{ asset('assets/javascript/register.js?id=04062024') }}" data-navigate-once></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
    <script src="/assets/js/pages-auth.js"></script>

    
    @livewireStyles
</head>

<body>
  <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  
  <!-- Content -->

  @if(Auth::check())
  <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            @include('layouts.sidebar')
            @yield('content')
        </div>
   </div>
  @else
    @yield('content')
  @endif
        
        
  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  
  <script src="/assets/vendor/libs/jquery/jquery.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/popper/popper.js" data-navigate-once></script>
  <script src="/assets/vendor/js/bootstrap.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/hammer/hammer.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/i18n/i18n.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/typeahead-js/typeahead.js" data-navigate-once></script>
  <script src="/assets/vendor/js/menu.js" data-navigate-once></script>
  
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="/assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/bs-stepper/bs-stepper.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/bootstrap-select/bootstrap-select.js" data-navigate-once></script>
  <script src="/assets/vendor/libs/select2/select2.js" data-navigate-once></script>
  <!-- Main JS -->
  <script src="/assets/js/main.js?{{ \Str::random(10) }}"></script>
  <script src="/assets/vendor/libs/apex-charts/apexcharts.js" data-navigate-once></script>

  <!-- Page JS -->
  <script src="/assets/js/app-ecommerce-dashboard.js"></script>
  <script src="/assets/js/form-wizard-icons.js"></script>
  <script src="/assets/js/form-wizard-numbered.js"></script>
  <script src="/assets/js/app-user-view-account.js"></script>
  <script src="/assets/js/app-user-view.js"></script>

  @livewireScripts
</body>

</html>

