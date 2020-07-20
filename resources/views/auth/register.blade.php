@extends('layouts.auth.auth')
@section('styles')
@endsection
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@section('content')
    <div class="row">
        <div class="col-md-6 text-center " style="background-size: cover;background-image: url(./assets/images/photo-long-3.jpg)">
            <div class="pl-3 auth-right">
                <div class="auth-logo text-center mt-4">
                    <img src={{asset("assets/images/logo.png")}} alt="">
                </div>
                <div class="flex-grow-1"></div>
                <div class="w-100 mb-4">
                    <a class="btn btn-outline-primary btn-block btn-icon-text btn-rounded" href="{{route
                    ('redirectToProvider', ['email'])}}">
                        <i class="i-Mail-with-At-Sign"></i> Sign in with Email
                    </a>
                    <a class="btn btn-outline-google btn-block btn-icon-text btn-rounded" href="{{route
                    ('redirectToProvider', ['google'])}}">
                        <i class="i-Google-Plus"></i> Sign in with Google
                    </a>
                    <a class="btn btn-outline-facebook btn-block btn-icon-text btn-rounded" href="{{route
                    ('redirectToProvider', ['facebook'])}}">
                        <i class="i-Facebook-2"></i> Sign in with Facebook
                    </a>
                    <a class="btn btn-outline-success btn-block btn-icon-text btn-rounded" href="{{route
                    ('redirectToProvider',
                    ['github'])}}">
                        <i class="fa fa-github" aria-hidden="true"></i> Login with GitHub
                    </a>
                </div>
                <div class="flex-grow-1"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4">

                <h1 class="mb-3 text-18">Sign Up</h1>
                <form method="POST" action="{{ route('signUpProcess') }}">
                    @csrf
                    <div class="form-group">
                        <label for="first-name">First name</label>
                        <input id="firstName" type="text" class="form-control form-control-rounded @error('first_name')
                                is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last name</label>
                        <input id="lastName" type="text" class="form-control form-control-rounded @error('last_name')
                                is-invalid
@enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="form-control form-control-rounded @error('username')
                                is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email" type="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone_code">Select</label>
                        <label>
                            <select name="phone_code" class="form-control form-control-rounded">
                                <option value="+880">+880</option>
                                <option value="+881">+881</option>
                                <option value="+882">+882</option>
                            </select>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" type="number" class="form-control form-control-rounded @error('phone')
                                is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

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
@endsection
