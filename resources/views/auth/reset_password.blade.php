@extends('auth.layouts.auth')

@section('content')
    <div class="auth-layout-wrap" style="background-image: url({{asset('assets/default/images/images.jpeg') }});">
        <div class="auth-content">
            <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{asset("assets/gull_template/images/logo.png")}}" alt="logo">
                            </div>
                            <h1 class="mb-3 text-18">{{__('Reset Your Password')}}</h1>
                            <form method="POST" action="{{ route('web.auth.reset_password_process') }}">
                                @csrf
                                @if(isset($email))
                                    <div class="form-group">
                                        <label>
                                            <input name = "email" type="hidden" class="form-control
                                            form-control-rounded" value = "{{$email}}">
                                        </label>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="reset_password_code">{{__('Reset Password Code')}}</label>
                                    <input name="reset_password_code" id="reset_password_code"
                                           class="form-control form-control-rounded" type="number"
                                           value="{{ old('reset_password_code') }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{__('New Password')}}</label>
                                    <input name="new_password" id="password" class="form-control form-control-rounded" type="password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">{{__('Confirm Password')}}</label>
                                    <input name="confirm_password" id="confirm_password" class="form-control form-control-rounded" type="password">
                                </div>
                                <button class="btn btn-primary btn-block btn-rounded mt-3">Reset Password</button>

                            </form>
                            <div class="mt-3 text-center">
                                <a class="text-muted" href="{{route('web.auth.sign_in')}}"><u>Sign in</u></a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
