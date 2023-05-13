<div class="row">
    <div class="col-md-4 mb-4">
        @include('shared.components.chart-legend-table', [
            'notEmptyChartElements' => [
                ['label' => 'Incomplete', 'value' => $orderStatusCountArray['incomplete']],
                ['label' => 'Completed', 'value' => $orderStatusCountArray['completed']],
                ['label' => 'Cancelled', 'value' => $orderStatusCountArray['cancelled']],
            ],
            'chartElementCount' => 3,
        ])

        <div class="chart-legend-explain-wrapper mt-4">
            <span class="incomplete-legend-explain">
                *Incomplete orders include: <i>received, processing, delivering</i> orders
            </span>
        </div>
    </div>

    <div class="col-md-8">
        <canvas id="orderStatusChart"></canvas>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/order-status-chart.js') }}"></script>
    <script>
        drawOrderStatusChart(
            {{ $orderStatusCountArray['incomplete'] }},
            {{ $orderStatusCountArray['completed'] }},
            {{ $orderStatusCountArray['cancelled'] }}
        );
    </script>
@endpush
