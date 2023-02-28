<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.page-header')
</head>

<body class="animsition">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">Welcome to The Admin Team</div>
                    <div class="login-form">
                        <form action="{{ route('admin.login.handler') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input class="au-input au-input--full" type="email" name="email" placeholder="Email"
                                    required>
                            </div>
                            @error('email')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <input class="au-input au-input--full" type="password" name="password"
                                    placeholder="Password" required>
                            </div>
                            @error('password')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                            <button class="au-btn au-btn--block au-btn--green m-b-10 m-t-20" type="submit">Sign in</button>
                            @if (Session::has(Constants::ACTION_ERROR))
                                <div class="alert alert-danger" role="alert">
                                    {{ Session::get(Constants::ACTION_ERROR) }}
                                </div>
                            @elseif (Session::has(Constants::ACTION_SUCCESS))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get(Constants::ACTION_SUCCESS) }}
                                </div>
                            @endif
                        </form>
                        <div class="register-link">
                            <p>
                                Don't you have account?
                                <a href="{{ route('admin.register') }}">Sign Up Here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.page-footer')
</body>

</html>
