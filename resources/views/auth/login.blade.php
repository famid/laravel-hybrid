@extends('layouts.auth.auth')
{{--@extends('layouts.app')--}}

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="p-4">
                <div class="auth-logo text-center mb-4">
                    <img src="assets/images/logo.png" alt="">
                </div>
                <h1 class="mb-3 text-18">Sign In</h1>
                <form method="POST" action="{{ route('signInProcess') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email" type="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 offset-left-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-rounded btn-primary btn-block mt-2">
                        {{ __('Sign In') }}
                    </button>



                </form>
                    <a class="btn btn-link" href="{{ route('forgetPasswordView') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                <div style="margin-top: 40Px">
                    <a href="{{route('signUp')}}">
                        <button class="btn btn-primary btn-block" type="button" id="signUp">
                            <i class="fas fa-user-plus"></i>Sign up New Account
                        </button>
                    </a>
                </div>
                {{--<div class="mt-3 text-center">
                    <a href="{{route('forgetPassword')}}" class="text-muted"><u>Forgot Password?</u></a>
                </div>--}}
            </div>
        </div>
        <div class="col-md-6 text-center " style="background-size: cover;">
            <div class="pr-3 auth-right">
                <a class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text" href="signup.html">
                    <i class="i-Mail-with-At-Sign"></i> Sign up with Email
                </a>
                <a class="btn btn-rounded btn-outline-google btn-block btn-icon-text">
                    <i class="i-Google-Plus"></i> Sign up with Google
                </a>
                <a class="btn btn-rounded btn-block btn-icon-text btn-outline-facebook" href="{{route
                    ('redirectToProvider', ['facebook'])}}">
                    <i class="i-Facebook-2"></i> Sign up with Facebook
                </a>
                <a class="btn btn-outline-success btn-block btn-icon-text btn-rounded" href="{{route
                    ('redirectToProvider',
                    ['github'])}}">
                    <i class="fa fa-github" aria-hidden="true"></i> Login with GitHub
                </a>
            </div>
        </div>
    </div>
    {{--<form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>--}}
@endsection
