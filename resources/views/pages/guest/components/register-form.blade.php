<form id="registerForm" action="{{ route('register-handler') }}" method="POST">
    @csrf
    <div class="form-group">
        <input class="au-input au-input--full" type="email" name="email" value="{{ old('email') }}" placeholder="Email"
            required>
        @error('email')
            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
        @enderror
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input class="au-input au-input--full" type="password" name="confirmPassword"
                    placeholder="Confirm password" required>
                @error('confirmPassword')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-group">
        <input class="au-input au-input--full" type="text" name="name" value="{{ old('name') }}"
            placeholder="Full name" required>
        @error('name')
            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
        @enderror
    </div>
    <button class="au-btn au-btn--block au-btn--green m-b-10 m-t-20" type="submit">Register</button>
</form>
