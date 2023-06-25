<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Analysis of orders by day of the month</h3>
    </div>

    <canvas id="ordersQtyAnalysisChart"></canvas>
    <div class="m-b-50"></div>
    <canvas id="ordersValueAnalysisChart"></canvas>
</div>

@php
    $chartLabels = [];
    $ordersPlacedQtyArray = [];
    $ordersPlacedValueArray = [];
    $ordersCancelledQtyArray = [];
    $ordersCancelledValueArray = [];

    foreach ($ordersAnalysis as $item) {
        $chartLabels[] = $item->day;
        $ordersPlacedQtyArray[] = $item->placed;
        $ordersPlacedValueArray[] = $item->placed_value / 1000;
        $ordersCancelledQtyArray[] = $item->cancelled;
        $ordersCancelledValueArray[] = $item->cancelled_value / 1000;
    }

    $ordersQtyAnalisisDatasetPropertiesObjects = [
        (object) [
            'label' => 'Placed',
            'data' => $ordersPlacedQtyArray,
            'lineColor' => 'rgba(50, 125, 240, 0.6)',
            'pointColor' => 'rgba(50, 125, 240, 1)',
        ],
        (object) [
            'label' => 'Cancelled',
            'data' => $ordersCancelledQtyArray,
            'lineColor' => 'rgba(225, 40, 30, 0.6)',
            'pointColor' => 'rgba(225, 40, 30, 1)',
        ],
    ];
    $ordersValueAnalysisDatasetPropertiesObjects = [
        (object) [
            'label' => 'Placed',
            'data' => $ordersPlacedValueArray,
            'lineColor' => 'rgba(50, 125, 240, 0.6)',
            'pointColor' => 'rgba(50, 125, 240, 1)',
        ],
        (object) [
            'label' => 'Cancelled',
            'data' => $ordersCancelledValueArray,
            'lineColor' => 'rgba(225, 40, 30, 0.6)',
            'pointColor' => 'rgba(225, 40, 30, 1)',
        ],
    ];
@endphp

@pushOnce('scripts')
    <script src="{{ asset('assets/js/monthly-report/line-chart.js') }}"></script>
@endPushOnce

@push('scripts')
    <script>
        drawMonthlyReportLineChart({
            canvasId: 'ordersQtyAnalysisChart',
            chartLabels: {{ Js::from($chartLabels) }},
            chartTitle: 'Orders quantity analysis',
            datasetPropertiesObjects: {{ Js::from($ordersQtyAnalisisDatasetPropertiesObjects) }}
        });
        drawMonthlyReportLineChart({
            canvasId: 'ordersValueAnalysisChart',
            chartLabels: {{ Js::from($chartLabels) }},
            chartTitle: 'Orders value analysis (in thousands of dollars)',
            datasetPropertiesObjects: {{ Js::from($ordersValueAnalysisDatasetPropertiesObjects) }}
        });
    </script>
@endpush
