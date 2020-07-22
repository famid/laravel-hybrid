<!DOCTYPE html>
<html lang="en">
    @include('user.layouts.header')
<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large clearfix">
        <!--=============== Top Bar Start ================-->
        @include('user.layouts.top_bar')
        <!--=============== Top Bar End ================-->

        <!--=============== Left side Start ================-->
        @include('user.layouts.sidebar')
        <!--=============== Left side End ================-->

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            @yield('content')
        <!-- ============ Body content End ============= -->
        <!-- ============ Footer Start ============= -->
            @include('user.layouts.footer')
        <!-- ============ Footer End ============= -->
        </div>
    </div>
<!--=============== End app-admin-wrap ================-->
@include('user.layouts.script')
@yield('script')
</body>

</html>