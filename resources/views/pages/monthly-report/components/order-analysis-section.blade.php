<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Analysis of orders by day of the month</h3>
    </div>

    <canvas id="orderQtyAnalysisChart"></canvas>
    <div class="m-b-40"></div>
    <canvas id="orderValueAnalysisChart"></canvas>
    <div class="mb-4"></div>
</div>

@php
    $chartLabels = [];
    $placedQtyArray = [];
    $placedValueArray = [];
    $cancelledQtyArray = [];
    $cancelledValueArray = [];

    foreach ($analysisData as $item) {
        $chartLabels[] = $item->day;
        $placedQtyArray[] = $item->placed;
        $placedValueArray[] = $item->placed_value / 1000;
        $cancelledQtyArray[] = $item->cancelled;
        $cancelledValueArray[] = $item->cancelled_value / 1000;
    }

    $orderQtyAnalisisDatasetPropertiesObjects = [
        (object) [
            'label' => 'Placed',
            'data' => $placedQtyArray,
            'lineColor' => 'rgba(50, 125, 240, 0.6)',
            'pointColor' => 'rgb(50, 125, 240)',
        ],
        (object) [
            'label' => 'Cancelled',
            'data' => $cancelledQtyArray,
            'lineColor' => 'rgba(225, 40, 30, 0.6)',
            'pointColor' => 'rgb(225, 40, 30)',
        ],
    ];
    $orderValueAnalysisDatasetPropertiesObjects = [
        (object) [
            'label' => 'Placed',
            'data' => $placedValueArray,
            'lineColor' => 'rgba(50, 125, 240, 0.6)',
            'pointColor' => 'rgb(50, 125, 240)',
        ],
        (object) [
            'label' => 'Cancelled',
            'data' => $cancelledValueArray,
            'lineColor' => 'rgba(225, 40, 30, 0.6)',
            'pointColor' => 'rgb(225, 40, 30)',
        ],
    ];
@endphp

@pushOnce('scripts')
    <script src="{{ asset('assets/js/monthly-report/line-chart.js') }}"></script>
@endPushOnce

@push('scripts')
    <script>
        drawMonthlyReportLineChart({
            canvasId: 'orderQtyAnalysisChart',
            chartLabels: {{ Js::from($chartLabels) }},
            chartTitle: 'Order quantity analysis',
            datasetPropertiesObjects: {{ Js::from($orderQtyAnalisisDatasetPropertiesObjects) }}
        });
        drawMonthlyReportLineChart({
            canvasId: 'orderValueAnalysisChart',
            chartLabels: {{ Js::from($chartLabels) }},
            chartTitle: 'Order value analysis (in thousands of dollars)',
            datasetPropertiesObjects: {{ Js::from($orderValueAnalysisDatasetPropertiesObjects) }}
        });
    </script>
@endpush
