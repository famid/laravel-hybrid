<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/gull_template/styles/css/themes/lite-purple.min.css')}}">
    <style>
        .alert {
            margin-bottom: 0px !important;
            border-radius: 0px !important;
        }
    </style>
</head>
<body class="text-left">
@yield('styles')
@if(Session::has('success'))
    <div class="alert-float alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{Session::get('success')}}
    </div>
@endif

@if(Session::has('error'))
    <div class="alert-float alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{Session::get('error')}}
    </div>
@endif
@if(!empty($errors) && count($errors) > 0)
    <div class="alert-float alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{$errors->first()}}
    </div>
@endif

{{--Region Content--}}
<div class="auth-layout-wrap">
    <div class="auth-content">
        <div class="card o-hidden">
            @yield('content')
        </div>
    </div>
</div>

<script src="{{asset('assets/gull_template/js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/gull_template/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/gull_template/js/es5/script.js')}}"></script>

@yield('scripts')
</body>

</html>
