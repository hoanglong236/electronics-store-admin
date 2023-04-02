<form action="{{ route('login.handler') }}" method="POST">
    @csrf
    <div class="form-group">
        <input class="au-input au-input--full au-input--small" type="email" name="email" value="{{ old('email') }}"
            placeholder="Email" required>
        @error('email')
            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <input class="au-input au-input--full au-input--small" type="password" name="password"
            value="{{ old('password') }}" placeholder="Password" required>
        @error('password')
            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
        @enderror
    </div>
    <button class="au-btn au-btn--block au-btn--green m-b-10 m-t-20" type="submit">Sign in</button>
</form>
