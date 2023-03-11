@extends('shared.layouts.base-layout')

@section('page-content')
    <div class="container" style="min-height: 92vh">
        <div class="login-wrap">
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        <img src="{{ asset('assets/images/icon/logo.png') }}" alt="CoolAdmin">
                    </a>
                </div>
                <div class="text-center">Register Account</div>
                <div class="login-form mt-4">
                    <form id="registerForm" action="{{ route('register.handler') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input class="au-input au-input--full" type="email" name="email" value="{{ old('email') }}"
                                placeholder="Email" required>
                        </div>
                        @error('email')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input class="au-input au-input--full" type="password" name="password"
                                        value="{{ old('password') }}" placeholder="Password" required>
                                </div>
                                @error('password')
                                    <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input class="au-input au-input--full" type="password" name="confirmPassword"
                                        value="{{ old('confirmPassword') }}" placeholder="Confirm your Password" required>
                                </div>
                                @error('confirmPassword')
                                    <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="au-input au-input--full" type="text" name="name"
                                value="{{ old('name') }}" placeholder="Full name" required>
                        </div>
                        @error('name')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                        <button class="au-btn au-btn--block au-btn--green m-b-10 m-t-20" type="submit">Register</button>
                        {{ Session::get('error_mess_register') }}
                        <div class="register-link">
                            <p>
                                Already have account?
                                <a href="{{ route('login') }}">Sign In</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
