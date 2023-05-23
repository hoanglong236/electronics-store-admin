<form action="{{ $searchUrl }}" method="GET">
    <div class="d-flex-center-space-between-wrap">
        <div class="dashboard-search-form-fields">
            <div class="dashboard-form-group">
                <label for="fromDate" class="dashboard-search-date-label">From:</label>
                <input id="fromDate" type="date" name="fromDate" value="{{ $fromDate }}" class="form-control"
                    required>
            </div>
            <div class="dashboard-form-group">
                <label for="toDate" class="dashboard-search-date-label">To:</label>
                <input id="toDate" type="date" name="toDate" value="{{ $toDate }}" class="form-control"
                    required>
            </div>
        </div>
        <div class="dashboard-form-search-actions">
            <button type="submit" class="primary-submit-btn">SEARCH</button>
        </div>
    </div>
</form>

@if ($errors->any())
    <script>
        const message = '{{ implode(' ', $errors->all()) }}';
        alert(message);
    </script>
@endif
