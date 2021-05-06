@extends('auth.layouts.auth')

@section('content')
    <div class="auth-layout-wrap" style="background-image: url('{{asset('assets/default/images/images.jpeg')}}');">
        <div class="row">
            <div class="col-md-12">
                <div class="p-4">
                    <div class="auth-logo text-center mb-4">
                        <img src="{{asset('assets/gull_template/images/logo.png')}}" alt="">
                    </div>
                    <h1 class="mb-3 text-18">Sign In</h1>
                    <form method="POST" action="{{ route('web.auth.sign_in_process') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input id="email" type="email" name="email" class="form-control form-control-rounded @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password"  name="password" class="form-control form-control-rounded @error('password') is-invalid @enderror"
                                   required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 offset-left-4">
                                <div class="form-check">
                                    <input id="remember" type="checkbox" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
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
                        <a class="btn btn-link" href="{{ route('web.auth.forget_password') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    <div style="margin-top: 40Px">
                        <a href="{{route('web.auth.sign_up')}}">
                            <button class="btn btn-primary btn-block" type="button" id="signUp">
                                <i class="fas fa-user-plus"></i>Sign up New Account
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center " style="background-size: cover;">
                <div class="p-4 auth-right">
                    <a class="btn btn-rounded btn-outline-google btn-block btn-icon-text"
                        href="{{route('web.auth.redirect_to_provider', ['google'])}}">
                        <i class="i-Google-Plus"></i>
                        Sign in with Google
                    </a>
                    <a class="btn btn-rounded btn-block btn-icon-text btn-outline-facebook"
                        href="{{route('web.auth.redirect_to_provider', ['facebook'])}}">
                        <i class="i-Facebook-2"></i>
                        Sign in with Facebook
                    </a>
                    <a class="btn btn-outline-success btn-block btn-icon-text btn-rounded"
                        href="{{route('web.auth.redirect_to_provider',['github'])}}">
                        <i class="fa fa-github" aria-hidden="true"></i>
                        Sign in with GitHub
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
