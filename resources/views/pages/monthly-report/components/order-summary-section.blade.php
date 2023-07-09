<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Summary of orders for the month</h3>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <canvas id="orderQtyChart"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="orderAvgQtyByDayChart"></canvas>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <canvas id="orderValueChart"></canvas>
        </div>
        <div class="col-md-4 mb-4">
            <canvas id="orderAvgTotalValueByDayChart"></canvas>
        </div>
        <div class="col-md-4 mb-4">
            <canvas id="orderAvgValueChart"></canvas>
        </div>
    </div>
</div>

@php
    $orderQtyChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Qty',
            'data' => [
                $summaryData['total']['qty']['placed'],
                $summaryData['total']['qty']['cancelled']
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $orderAvgQtyByDayChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Qty',
            'data' => [
                number_format($summaryData['avg']['qtyByDay']['placed'], 2),
                number_format($summaryData['avg']['qtyByDay']['cancelled'], 2)
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $orderValueChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Value',
            'data' => [
                $summaryData['total']['value']['placed'] / 1000,
                $summaryData['total']['value']['cancelled'] / 1000
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $orderAvgTotalValueByDayChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Value',
            'data' => [
                floatval(number_format($summaryData['avg']['totalValueByDay']['placed'] / 1000, 2)),
                floatval(number_format($summaryData['avg']['totalValueByDay']['cancelled'] / 1000, 2))
            ],
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $orderAvgValueChartDatasetPropertiesObjects = [
        (object) [
            'label' => 'Value',
            'data' => [
                floatval(number_format($summaryData['avg']['value']['placed'] / 1000, 2)),
                floatval(number_format($summaryData['avg']['value']['cancelled'] / 1000, 2))
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
            canvasId: 'orderAvgQtyByDayChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Avg. order quantity by day',
            datasetPropertiesObjects: {{ Js::from($orderAvgQtyByDayChartDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'orderValueChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Order value (in K dollars)',
            datasetPropertiesObjects: {{ Js::from($orderValueChartDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'orderAvgTotalValueByDayChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Avg. total order value by day (in K dollars)',
            datasetPropertiesObjects: {{ Js::from($orderAvgTotalValueByDayChartDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'orderAvgValueChart',
            chartLabels: ['Placed', 'Cancelled'],
            chartTitle: 'Avg. order value (in K dollars)',
            datasetPropertiesObjects: {{ Js::from($orderAvgValueChartDatasetPropertiesObjects) }}
        });
    </script>
@endpush
