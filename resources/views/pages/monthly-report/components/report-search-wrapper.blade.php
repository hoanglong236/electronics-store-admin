<form action="" method="get">
    <div class="report-form-wrapper">
        <div class="report-form-conditions">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="monthReport" class="form-control-label">Month:</label>
                        <input id="monthReport" type="number" class="form-control month-report-input" name="month"
                            value="{{ old('month') }}" min="1" max="12" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="monthReport" class="form-control-label">Year:</label>
                        <input id="yearReport" type="number" class="form-control year-report-input" name="year"
                            value="{{ old('year') }}" min="2000" max="9999" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="form-group">
                        <label for="typeReport" class="form-control-label">Type:</label>
                        <select id="typeReport" name="type" class="form-control" required>
                            <option value="category">Category</option>
                            <option value="brand">Brand</option>
                            <option value="product">Product</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="form-group">
                        <label for="typeReportId" class="form-control-label">Type ID</label>
                        <input id="typeReportId" type="text" name="typeId" class="form-control"
                            value="{{ old('typeId') }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="report-form-actions">
            <button class="dashboard-search-btn">SEARCH</button>
        </div>
    </div>
</form>

@if ($errors->any())
    <script>
        const message = '{{ implode(' ', $errors->all()) }}';
        alert(message);
    </script>
@endif
