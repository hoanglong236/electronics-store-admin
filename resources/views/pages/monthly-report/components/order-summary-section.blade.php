<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Summary of orders for the month</h3>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <canvas id="orderQtyChart"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="orderAvgQtyChart"></canvas>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <canvas id="orderValueChart"></canvas>
        </div>
        <div class="col-md-4 mb-4">
            <canvas id="orderAvgValueByDayChart"></canvas>
        </div>
        <div class="col-md-4 mb-4">
            <canvas id="orderAvgValueByQtyChart"></canvas>
        </div>
    </div>
</div>

@php
    $orderQtyChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Qty',
            'data' => [
                $summaryData['all']['qty']['placed'],
                $summaryData['all']['qty']['cancelled']
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $orderAvgQtyChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Qty',
            'data' => [
                number_format($summaryData['avg']['qty']['placed'], 2),
                number_format($summaryData['avg']['qty']['cancelled'], 2)
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $orderValueChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Value',
            'data' => [
                $summaryData['all']['value']['placed'] / 1000,
                $summaryData['all']['value']['cancelled'] / 1000
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $orderAvgValueByDayChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Value',
            'data' => [
                floatval(number_format($summaryData['avg']['valueByDay']['placed'] / 1000, 2)),
                floatval(number_format($summaryData['avg']['valueByDay']['cancelled'] / 1000, 2))
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $orderAvgValueByQtyChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Value',
            'data' => [
                floatval(number_format($summaryData['avg']['valueByQty']['placed'] / 1000, 2)),
                floatval(number_format($summaryData['avg']['valueByQty']['cancelled'] / 1000, 2))
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];
@endphp

@pushOnce('scripts')
    <script src="{{ asset('assets/js/monthly-report/bar-chart.js') }}"></script>
@endPushOnce

@push('scripts')
    <script>
        drawMonthlyReportBarChart({
            canvasId: 'orderQtyChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Order quantity',
            datasetPropertiesObjects: {{ Js::from($orderQtyChartDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'orderAvgQtyChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Avg order quantity by day',
            datasetPropertiesObjects: {{ Js::from($orderAvgQtyChartDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'orderValueChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Total order value (in K dollars)',
            datasetPropertiesObjects: {{ Js::from($orderValueChartDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'orderAvgValueByDayChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Avg order value by day (in K dollars)',
            datasetPropertiesObjects: {{ Js::from($orderAvgValueByDayChartDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'orderAvgValueByQtyChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Avg order value by qty (in K dollars)',
            datasetPropertiesObjects: {{ Js::from($orderAvgValueByQtyChartDatasetPropertiesObjects) }}
        });
    </script>
@endpush
