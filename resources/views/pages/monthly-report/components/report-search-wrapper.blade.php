<form action="" method="get">
    <div class="d-flex-center-space-between-wrap">
        <div class="d-flex-wrap">
            <div class="d-flex-wrap m-r-25">
                <label for="monthReport" class="mr-3 mb-0">Month:</label>
                <input id="monthReport" type="number" class="form-control month-report-input" name="month"
                    value="{{ old('month') }}" min="1" max="12" required>
            </div>
            <div class="d-flex-wrap">
                <label for="monthReport" class="mr-3 mb-0">Year:</label>
                <input id="yearReport" type="number" class="form-control year-report-input" name="year"
                    value="{{ old('year') }}" min="2000" max="9999" required>
            </div>
        </div>
        <div class="report-form-actions">
            <button class="primary-submit-btn">SEARCH</button>
        </div>
    </div>
</form>

@if ($errors->any())
    <script>
        const message = '{{ implode(' ', $errors->all()) }}';
        alert(message);
    </script>
@endif
