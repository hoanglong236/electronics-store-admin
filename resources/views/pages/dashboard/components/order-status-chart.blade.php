@php
    $incompleteOrderCount = $orderStatusCountArray[Constants::ORDER_STATUS_RECEIVED] + $orderStatusCountArray[Constants::ORDER_STATUS_PROCESSING] + $orderStatusCountArray[Constants::ORDER_STATUS_DELIVERING];
    $totalOrderCount = $incompleteOrderCount + $orderStatusCountArray[Constants::ORDER_STATUS_COMPLETED] + $orderStatusCountArray[Constants::ORDER_STATUS_CANCELLED];
@endphp

<div class="row">
    <div class="col-md-4">
        <table class="table order-chart-legend-table">
            <tbody>
                <tr>
                    <td><span class="dot dot--incomplete"></span></td>
                    <td>Incomplete</td>
                    <td>{{ $incompleteOrderCount }}</td>
                    <td>{{ round(($incompleteOrderCount / $totalOrderCount) * 100, 2) }}%</td>
                </tr>
                <tr>
                    <td><span class="dot dot--completed"></span></td>
                    <td>Completed</td>
                    <td>{{ $orderStatusCountArray[Constants::ORDER_STATUS_COMPLETED] }}</td>
                    <td>
                        {{ round(($orderStatusCountArray[Constants::ORDER_STATUS_COMPLETED] / $totalOrderCount) * 100, 2) }}%
                    </td>
                </tr>
                <tr>
                    <td><span class="dot dot--cancelled"></span></td>
                    <td>Cancelled</td>
                    <td>{{ $orderStatusCountArray[Constants::ORDER_STATUS_CANCELLED] }}</td>
                    <td>
                        {{ round(($orderStatusCountArray[Constants::ORDER_STATUS_CANCELLED] / $totalOrderCount) * 100, 2) }}%
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="chart-legend-explain-wrapper my-5">
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
