<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{url('/assets/')}}"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{url('/assets/img/favicon/favicon.ico')}}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{url('/assets/vendor/fonts/boxicons.css')}}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{url('/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{url('/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{url('/assets/css/demo.css')}}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{url('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

  <link rel="stylesheet" href="{{url('/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
  <!-- Boxicons CDN -->
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="{{url('/assets/vendor/js/helpers.js')}}"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="{{url('/assets/js/config.js')}}"></script>
  @section('css')
  @show

</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      @include('layouts.sidebar')
      <div class="layout-page">
        @include('layouts.header')
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('layouts.footer')
      </div>
    </div>
  </div>
</body>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{url('/assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{url('/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{url('/assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{url('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{url('/assets/vendor/js/menu.js')}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{url('/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

<!-- Main JS -->
<script src="{{url('/assets/js/main.js')}}"></script>

<!-- Page JS -->
<script src="{{url('/assets/js/dashboards-analytics.js')}}"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>