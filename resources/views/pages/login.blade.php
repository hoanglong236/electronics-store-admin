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
                        <form action="/loginHandler" method="POST">
                            @csrf
                            <div class="form-group">
                                <input class="au-input au-input--full" type="email" name="email" placeholder="Email"
                                    required>
                            </div>
                            <div class="form-group">
                                <input class="au-input au-input--full" type="password" name="password"
                                    placeholder="Password" required>
                            </div>
                            <div class="mt-4">
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign
                                    in</button>
                            </div>
                            @if (Session::has('error_mess'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error_mess') }}
                                </div>
                            @elseif (Session::has('success_mess'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success_mess') }}
                                </div>
                            @endif
                        </form>
                        <div class="register-link">
                            <p>
                                Don't you have account?
                                <a href="/register">Sign Up Here</a>
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
