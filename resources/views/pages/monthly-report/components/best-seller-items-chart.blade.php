<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">{{ $chartData['title'] }}</h3>
    </div>

    <canvas id="{{ $chartData['chartElementId'] }}"></canvas>
</div>

@push('scripts')
    @once
        <script src="{{ asset('assets/js/monthly-report/best-seller-items-chart.js') }}"></script>
        <script>
            let bestSellerItemsDataset = [];
            let bestSellerChartId = '';
            let bestSellerChartTitle = '';
        </script>
    @endonce

    <script>
        bestSellerItemsDataset = {{ Js::from($chartData['bestSellerItems']) }};
        bestSellerChartId = '{{ $chartData['chartElementId'] }}';
        bestSellerChartTitle = '{{ $chartData['chartElementTitle'] }}';
        handleDrawBestSellerItemsChart(bestSellerItemsDataset, bestSellerChartId, bestSellerChartTitle);
    </script>
@endpush
