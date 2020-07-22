<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link id="gull-theme" rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">

    @yield('style')
</head>

<body class="text-left">
<!-- Pre Loader Strat  -->
<div class='loadscreen' id="preloader">

    <div class="loader spinner-bubble spinner-bubble-primary">



    </div>
</div>
<!-- Pre Loader end  -->
<div class="app-admin-wrap layout-sidebar-large clearfix">
    <!--=============== header start ================-->
    @include('layouts.admin.header')
<!--=============== header end ================-->
    <!--=============== Left side bar start ================-->
    @include('layouts.admin.sidebar')
    <!--=============== Left side bar End ================-->

    <!-- ============ Body content start ============= -->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        @yield('content')
        <!-- Footer Start -->
        @include('layouts.admin.footer')
            @yield('footer')
            <!-- footer end -->
    </div>
    <!-- ============ Body content End ============= -->
</div>
<!--=============== End app-admin-wrap ================-->

<script src="{{asset('assets/js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>

<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.min.js')}}"></script>

<script src="{{asset('assets/js/es5/script.min.js')}}"></script>
<script src="{{asset('assets/js/es5/sidebar.large.script.min.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
@yield('script')
</body>

</html>