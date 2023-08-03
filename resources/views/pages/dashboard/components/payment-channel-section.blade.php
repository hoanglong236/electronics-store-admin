<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Payment channels</h3>
    </div>

    @php
        $chartLabels = [];
        $chartData = [];
        $chartElements = [];
        foreach ($orderQtyByPaymentMethods as $paymentMethod => $qty) {
            $chartLabels[] = $paymentMethod;
            $chartData[] = $qty;
            $chartElements[] = [
                'label' => $paymentMethod,
                'value' => $qty,
            ];
        }
        $chartColors = ['#407FF6', '#5BAD60'];
    @endphp

    <canvas id="paymentChannels"></canvas>
    <div class="mt-4">
        @include('shared.components.charts.pie-chart-legend', [
            'chartElementCount' => count($chartElements),
            'notEmptyChartElements' => $chartElements,
            'chartElementColors' => $chartColors,
        ])
    </div>
</div>

@php
    $paymentChannelsDatasetPropertiesObject = (object) [
        'data' => $chartData,
        'sliceColors' => $chartColors,
    ];
@endphp

@pushOnce('scripts')
    <script src="{{ asset('assets/js/dashboard/pie-chart.js') }}"></script>
@endPushOnce

@push('scripts')
    <script>
        drawDashboardPieChart({
            canvasId: 'paymentChannels',
            chartLabels: {{ Js::from($chartLabels) }},
            chartTitle: 'Payment channels',
            datasetPropertiesObject: {{ Js::from($paymentChannelsDatasetPropertiesObject) }}
        });
    </script>
@endpush
