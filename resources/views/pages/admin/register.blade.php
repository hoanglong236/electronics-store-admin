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
                    <div class="login-logo">Register Account</div>
                    <div class="login-form">
                        <form id="registerForm" action="{{ route('admin.register.handler') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input class="au-input au-input--full" type="email"
                                    name="email" placeholder="Email" required>
                            </div>
                            @error('email')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input class="au-input au-input--full" type="password"
                                            name="password" placeholder="Password" required>
                                    </div>
                                    @error('password')
                                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input class="au-input au-input--full" type="password"
                                            name="confirm-password" placeholder="Confirm your Password" required>
                                    </div>
                                    @error('confirm-password')
                                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="au-input au-input--full" type="text" name="name"
                                    placeholder="Full name" required>
                            </div>
                            @error('name')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <input class="au-input au-input--full" type="text" name="phone"
                                    placeholder="Phone number" required>
                            </div>
                            @error('phone')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                            <button class="au-btn au-btn--block au-btn--green m-b-10 m-t-20" type="submit">Register</button>
                            {{ Session::get('error_mess_register') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.page-footer')
</body>

</html>
