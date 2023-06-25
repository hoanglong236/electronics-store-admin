<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Summary of orders for the month</h3>
    </div>

    @php
        $kPlacedValue = number_format($ordersSummary->placed_value / 1000, 3);
        $kCancelledValue = number_format($ordersSummary->cancelled_value / 1000, 3);
    @endphp

    <div class="row">
        <div class="col-md-6 mb-4">
            <canvas id="ordersQtySummaryChart"></canvas>
            <div class="mt-4"></div>
            @include('shared.components.charts.pie-chart-legend', [
                'notEmptyChartElements' => [
                    ['label' => 'Placed', 'value' => $ordersSummary->placed],
                    ['label' => 'Cancelled', 'value' => $ordersSummary->cancelled],
                ],
                'chartElementColors' => ['rgba(50, 125, 240, 0.6)', 'rgba(225, 40, 30, 0.6)'],
                'chartElementCount' => 2,
            ])
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="ordersValueSummaryChart"></canvas>
            <div class="mt-4"></div>
            @include('shared.components.charts.pie-chart-legend', [
                'notEmptyChartElements' => [
                    ['label' => 'Placed value', 'value' => $kPlacedValue],
                    ['label' => 'Cancelled value', 'value' => $kCancelledValue],
                ],
                'chartElementColors' => ['rgba(50, 125, 240, 0.6)', 'rgba(225, 40, 30, 0.6)'],
                'chartElementCount' => 2,
            ])
        </div>
    </div>
</div>

@pushOnce('scripts')
    <script src="{{ asset('assets/js/monthly-report/pie-chart.js') }}"></script>
@endPushOnce

@push('scripts')
    <script>
        drawMonthlyReportPieChart({
            canvasId: 'ordersQtySummaryChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Summary of orders quantity',
            chartData: [{{ $ordersSummary->placed }}, {{ $ordersSummary->cancelled }}],
            chartSliceColors: ["rgba(50, 125, 240, 0.6)", "rgba(225, 40, 30, 0.6)"]
        });
        drawMonthlyReportPieChart({
            canvasId: 'ordersValueSummaryChart',
            chartLabels: ['Placed value', 'Cancelled value'],
            chartTitle: 'Summary of orders value (in thousands of dollars)',
            chartData: [{{ $kPlacedValue }}, {{ $kCancelledValue }}],
            chartSliceColors: ["rgba(50, 125, 240, 0.6)", "rgba(225, 40, 30, 0.6)"]
        });
    </script>
@endpush
