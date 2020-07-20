@extends('layouts.auth.auth')
{{--@extends('layouts.app')--}}

@section('content')
    <body class="text-left">
    <div class="auth-layout-wrap" style="">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <img src="" alt="">
                            </div>
                            <h1 class="mb-3 text-18">Forgot Password</h1>
                            <form method="POST" action="{{ route('forgetPasswordEmailSendProcess') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{__('Email/Username')}}</label>
                                    <input name="email" id="email" class="form-control form-control-rounded" type="text" value="{{ old('email') }}">
                                </div>
                                <button class="btn btn-primary btn-block btn-rounded mt-3">Reset Password</button>

                            </form>
                            <div class="mt-3 text-center">
                                <a class="text-muted" href="{{route('signIn')}}"><u>Sign in</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection