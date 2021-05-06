@extends('auth.layouts.auth')

@section('content')
    <div class="auth-layout-wrap" style="background-image: url({{asset('assets/default/images/images.jpeg') }});">
        <div class="auth-content">
            <div class="row">
                    <div class="col-md-12">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{asset("assets/gull_template/images/logo.png")}}" alt="logo">
                            </div>
                            <h1 class="mb-3 text-18">Forgot Password</h1>
                            <form method="POST" action="{{ route('web.auth.forget_password_email_send_process') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{__('Email/Username')}}</label>
                                    <input name="email" id="email" class="form-control form-control-rounded" type="text" value="{{ old('email') }}">
                                </div>
                                <button class="btn btn-primary btn-block btn-rounded mt-3">{{__('Send Recovery Code')}}</button>
                            </form>
                            <div class="mt-3 text-center">
                                <a class="text-muted" href="{{route('web.auth.sign_in')}}"><u>Sign in</u></a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    <div>
@endsection
