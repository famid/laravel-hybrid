@extends('auth.layouts.auth')
@section('styles')
@endsection
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@section('content')
    <div class="auth-layout-wrap" style="background-image: url({{asset('assets/default/images/images.jpeg') }});">
        <div class="row">
            <div class="col-md-12 text-center ">
                <div class="p-4 auth-right">
                    <div class="auth-logo text-center mt-4">
                        <img src="{{asset("assets/gull_template/images/logo.png")}}" alt="logo">
                    </div>
                    <div class="flex-grow-1"></div>
                    <div class="w-100 mb-4">
                        <a class="btn btn-outline-google btn-block btn-icon-text btn-rounded"
                           href="{{route('web.auth.redirect_to_provider', ['google'])}}">
                            <i class="i-Google-Plus"></i>
                            Sign Up with Google
                        </a>
                        <a class="btn btn-outline-facebook btn-block btn-icon-text btn-rounded"
                           href="{{route('web.auth.redirect_to_provider', ['facebook'])}}">
                            <i class="i-Facebook-2"></i>
                            Sign Up with Facebook
                        </a>
                        <a class="btn btn-outline-success btn-block btn-icon-text btn-rounded"
                           href="{{route('web.auth.redirect_to_provider',['github'])}}">
                            <i class="fa fa-github" aria-hidden="true"></i>
                            Login with GitHub
                        </a>
                    </div>
                    <div class="flex-grow-1"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="p-4">
                    <h1 class="mb-3 text-18">Sign Up</h1>
                    <form method="POST" action="{{ route('web.auth.sign_up_process') }}">
                        @csrf
                        <div class="form-group">
                            <label for="first-name">First name</label>
                            <input id="firstName" type="text" name="first_name" class="form-control form-control-rounded  @error('first_name') is-invalid @enderror"
                                   value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last name</label>
                            <input id="lastName" type="text" name="last_name" class="form-control form-control-rounded @error('last_name') is-invalid @enderror"
                                   value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" type="text" name="username" class="form-control form-control-rounded @error('username') is-invalid @enderror"
                                   value="{{ old('username') }}" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input id="email" type="email" name="email" class="form-control form-control-rounded @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone_code">Select Your Phone Code</label>
                            <select name="phone_code" class="form-control form-control-rounded">
                                <option value="+880">+880</option>
                                <option value="+881">+881</option>
                                <option value="+882">+882</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input id="phone" type="tel" name="phone" class="form-control form-control-rounded @error('phone')is-invalid @enderror"
                                   value="{{ old('phone') }}" required autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password"  class="form-control form-control-rounded @error('password') is-invalid @enderror"
                                   required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Retype password</label>
                            <input id="password-confirm" type="password" class="form-control form-control-rounded" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-rounded mt-3">
                            {{ __('Sign Up') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
