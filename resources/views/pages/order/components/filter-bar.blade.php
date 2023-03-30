<form action="{{ $filterFormUrl }}">
    <input type="hidden" name="searchKeyword" value="{{ $searchKeyword }}">
    <input type="hidden" name="searchOption" value="{{ $searchOption }}">

    <div class="filter-wrapper mt-3">
        <span class="mr-2">Filter by: </span>
        <select class="au-select-input au-select-input--small ml-2" name="statusFilter" onchange="this.form.submit()">
            @foreach ($statusFilters as $statusFilter)
                <option value="{{ $statusFilter }}" @selected($statusFilter === $currentStatusFilter)>
                    {{ 'Status: ' . $statusFilter }}
                </option>
            @endforeach
        </select>
        <select class="au-select-input au-select-input--small ml-2" name="paymentFilter" onchange="this.form.submit()">
            @foreach ($paymentFilters as $paymentFilter)
                <option value="{{ $paymentFilter }}" @selected($paymentFilter === $currentPaymentFilter)>
                    {{ 'Payment: ' . $paymentFilter }}
                </option>
            @endforeach
        </select>
    </div>
</form>
