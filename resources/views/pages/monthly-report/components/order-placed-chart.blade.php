<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Order statistics</h3>
    </div>

    <canvas id="orderPlacedChart"></canvas>

    @push('scripts')
        <script src="{{ asset('assets/js/monthly-report/order-placed-chart.js') }}"></script>
        <script>
            const dataset = {{ Js::from($orderPlacedDataset) }};
            handleDrawOrderPlacedChart(dataset);
        </script>
    @endpush
</div>
