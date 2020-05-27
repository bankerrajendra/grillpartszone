@extends('layouts.app-login')

@section('content')
    <div class="user-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div id="login">
                        <form method="POST" action="{{ route('register') }}">
                            <input type="hidden" name="redirect" value="{{$redirect}}" />
                            @csrf
                            <h3>{{ __('Create Account') }}</h3>
                            <hr>
                            <div class="form-group">
                                <label for="name">{{ __('Your Name') }}:</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Enter Name') }}" id="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}:</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}:</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Enter Password') }}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">{{ __('Re-enter Password') }}:</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Enter Confirm Password') }}">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn-warning" value="{{ __('SignUp') }}">
                            </div>
                            <hr>
                            <div class="form-group text-center">
                                {{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login Now!') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
