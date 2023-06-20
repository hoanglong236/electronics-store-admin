<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Order placed statistics</h3>
    </div>

    <canvas id="orderPlacedChart"></canvas>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/monthly-report/order-placed-chart.js') }}"></script>
    <script>
        const orderPlacedDataset = {{ Js::from($orderPlacedDataset) }};
        handleDrawOrderPlacedChart(orderPlacedDataset);
    </script>
@endpush
