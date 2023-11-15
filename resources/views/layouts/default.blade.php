<!DOCTYPE html>
<html lang="en">



<head>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="Phoenixcoded">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App - @yield('title') </title>
    @include('includes.style')
    @yield('pageCss')

    <style>
        .error {
          color: red;
       }
    </style>

</head>
<div class="loader-bg">
<div class="loader-track">
    <div class="loader-fill"></div>
</div>
</div>
<body>

    <!-- [ Sidebar Menu ] start -->
    @include('includes.sidebar')
   <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    @include('includes.navbar')
   <!-- [ Header ] end -->

     <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
            @include('includes.modal')
        </div>
    </div>
     <!-- [ Main Content ] end -->

     <!-- Footer -->
     @include('includes.footer')
     <!-- Footer -->

    <!-- Required Js -->
      <!--scrtipt -->
      @stack('before-script')

      @include('includes.script')

      @stack('after-script')

      @yield('pageJs')
      <script type="text/javascript">
        const baseUrl = "{{ url('/') }}";
    </script>

</body>


</html>
