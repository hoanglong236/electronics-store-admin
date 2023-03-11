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
                <div class="text-center">Welcome to The Admin Team</div>
                <div class="login-form mt-4">
                    @include('pages.guest.components.login-form')

                    <div class="register-link">
                        <p>
                            Don't you have account?
                            <a href="{{ route('register') }}">Sign Up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
