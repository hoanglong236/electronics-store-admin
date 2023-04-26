<form action="">
    @csrf
    <div class="dashboard-search-form-wrapper">
        <div class="dashboard-form-group">
            <label for="fromDate">From:</label>
            <input id="fromDate" type="date" name="fromDate" value="{{ old('name') }}" class="form-control" required>
            @error('fromDate')
            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="dashboard-form-group">
            <label for="toDate">To:</label>
            <input id="toDate" type="date" name="toDate" value="{{ old('name') }}" class="form-control" required>
            @error('toDate')
            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="dashboard-form-action">
            <button type="submit" class="dashboard-search-btn">SEARCH</button>
        </div>
    </div>
</form>
