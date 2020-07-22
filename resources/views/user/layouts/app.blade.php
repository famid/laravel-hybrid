<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gull - Laravel + Bootstrap 4 admin template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
    <style>
        .alert {
            margin-bottom: 0px !important;
            border-radius: 0px !important;
        }
    </style>
</head>

<body class="text-left">
@yield('styles')
<div class="auth-layout-wrap">
    <div class="auth-content">
        <div class="card o-hidden">
            @yield('content')
        </div>
    </div>
</div>

<script src="{{asset('assets/js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/es5/script.min.js')}}"></script>
</body>

</html>