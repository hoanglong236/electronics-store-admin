<form action="{{ $searchUrl }}" method="GET">
    <div class="d-flex-center-space-between-wrap">
        <div class="d-flex-wrap">
            <div class="dashboard-form-group m-r-25">
                <label for="fromDate" class="dashboard-search-date-label mr-3 mb-0">From:</label>
                <input id="fromDate" type="date" name="fromDate" value="{{ $fromDate }}" class="form-control"
                    required>
            </div>
            <div class="dashboard-form-group">
                <label for="toDate" class="dashboard-search-date-label mr-3 mb-0">To:</label>
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
