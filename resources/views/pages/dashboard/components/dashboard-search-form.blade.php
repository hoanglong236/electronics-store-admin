<form action="{{ $searchUrl }}" method="GET">
    <div class="dashboard-search-form-wrapper">
        <div class="dashboard-form-group">
            <label for="fromDate">From:</label>
            <input id="fromDate" type="date" name="fromDate" value="{{ $fromDate }}" class="form-control" required>
        </div>
        <div class="dashboard-form-group">
            <label for="toDate">To:</label>
            <input id="toDate" type="date" name="toDate" value="{{ $toDate }}" class="form-control"
                required>
        </div>
        <div class="dashboard-form-action">
            <button type="submit" class="dashboard-search-btn">SEARCH</button>
        </div>
    </div>
</form>

@if ($errors->any())
    <script>
        const message = '{{ implode(' ', $errors->all()) }}';
        alert(message);
    </script>
@endif
