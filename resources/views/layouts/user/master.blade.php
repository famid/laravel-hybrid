<!DOCTYPE html>
<html lang="en">
    @include('layouts.user.header')
<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large clearfix">
        <!--=============== Top Bar Start ================-->
        @include('layouts.user.top_bar')
        <!--=============== Top Bar End ================-->

        <!--=============== Left side Start ================-->
        @include('layouts.user.sidebar')
        <!--=============== Left side End ================-->

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            @yield('content')
        <!-- ============ Body content End ============= -->
        <!-- ============ Footer Start ============= -->
            @include('layouts.user.footer')
        <!-- ============ Footer End ============= -->
        </div>
    </div>
<!--=============== End app-admin-wrap ================-->
@include('layouts.user.script')
@yield('script')
</body>

</html>