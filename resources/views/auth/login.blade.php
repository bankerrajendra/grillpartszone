@extends('layouts.app-login')

@section('content')
    <div class="user-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div id="login">
                        <form method="POST" action="{{ route('login') }}">
                            <input type="hidden" name="redirect" value="{{$redirect}}" />
                            @csrf
                            <h3>Sign-In</h3>
                            <hr>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email" id="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" placeholder="Enter Password" id="password" @error('password') is-invalid @enderror name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember login
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn-warning" value="Login">
                            </div>
                            @if (Route::has('password.request'))
                            <div class="form-group text-center">
                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                            </div>
                            @endif
                            <hr>
                            <div class="form-group text-center">
                                Don't have an account? @if($redirect != '')<a href="{{ route('register', ['redirect' => $redirect]) }}">@else <a href="{{ route('register') }}"> @endif Sign Up Now!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
