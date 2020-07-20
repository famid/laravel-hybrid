@extends('layouts.app')

@section('content')
    <div class="mh-home image-bg home-2-img" id="mh-home" style="height: 100%">
        <div class="img-foverlay img-color-overlay" style="height: 100%">
            <div class="container">
                <div class="row section-separator xs-column-reverse vertical-middle-content" style="padding-top: 17%">
                    <div class="col-sm-6">
                        <h1 class="mb-3 text-18">{{__('Verify Email')}}</h1>
                        <form method="POST" action="{{ route('verifyEmailProcess') }}">
                           @csrf
                            <div class="form-group">
                                <label for="email_verification_code">{{__('Email Verification Code')}}</label>
                                <input id="email_verification_code" type="number" class="form-control form-control-rounded @error('email_verification_code') is-invalid @enderror" name="email_verification_code" value="{{ old('email_verification_code') }}" required autocomplete="email_verification_code" autofocus>

                                @error('email_verification_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-rounded btn-primary btn-block mt-2">
                                {{ __('Submit') }}
                            </button>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
