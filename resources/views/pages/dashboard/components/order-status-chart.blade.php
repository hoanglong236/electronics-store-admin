@php
    $incompleteOrderCount = $orderStatusCountArray[Constants::ORDER_STATUS_RECEIVED] + $orderStatusCountArray[Constants::ORDER_STATUS_PROCESSING] + $orderStatusCountArray[Constants::ORDER_STATUS_DELIVERING];
@endphp

<div class="row">
    <div class="col-md-4 mb-4">
        @include('shared.components.chart-legend-table', [
            'notEmptyChartElements' => [
                [
                    'label' => 'Incomplete',
                    'value' => $incompleteOrderCount,
                ],
                [
                    'label' => 'Completed',
                    'value' => $orderStatusCountArray[Constants::ORDER_STATUS_COMPLETED],
                ],
                [
                    'label' => 'Cancelled',
                    'value' => $orderStatusCountArray[Constants::ORDER_STATUS_CANCELLED],
                ],
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
            {{ $incompleteOrderCount }},
            {{ $orderStatusCountArray[Constants::ORDER_STATUS_COMPLETED] }},
            {{ $orderStatusCountArray[Constants::ORDER_STATUS_CANCELLED] }}
        );
    </script>
@endpush
