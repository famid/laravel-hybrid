<div class="main-header">
    <div class="logo">
        <img src="./assets/gull_template/images/logo.png" alt="">
    </div>

    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="d-flex align-items-center">
    </div>

    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>

        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <img src="{{asset('assets/gull_template/images/faces/1.jpg')}}" id="userDropdown" alt=""
                     data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> Timothy Carlson
                    </div>
                    <a class="dropdown-item" href="{{route('web.auth.sign_out')}}">Sign out</a>
                </div>
            </div>
        </div>
    </div>
</div>
