<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Summary of orders for the month</h3>
    </div>

    <div class="row">
        <div class="col-md-6">
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
        <div class="col-md-6">
            <canvas id="ordersValueSummaryChart"></canvas>
            <div class="mt-4"></div>
            @include('shared.components.charts.pie-chart-legend', [
                'notEmptyChartElements' => [
                    ['label' => 'Placed value', 'value' => $ordersSummary->placed_value],
                    ['label' => 'Cancelled value', 'value' => $ordersSummary->cancelled_value],
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
            chartTitle: 'Summary of orders value',
            chartData: [{{ $ordersSummary->placed_value }}, {{ $ordersSummary->cancelled_value }}],
            chartSliceColors: ["rgba(50, 125, 240, 0.6)", "rgba(225, 40, 30, 0.6)"]
        });
    </script>
@endpush
