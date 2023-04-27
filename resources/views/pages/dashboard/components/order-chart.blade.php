<div class="au-card m-b-30">
    <div class="au-card-inner">
        <h3 class="title-2 m-b-40">Order Chart</h3>
        <canvas id="orderChart"></canvas>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/order-chart.js') }}"></script>
    <script>
        drawOrderChart(
            {{ $orderStatisticData['statusCount'][Constants::ORDER_STATUS_COMPLETED] }},
            {{ $orderStatisticData['statusCount'][Constants::ORDER_STATUS_INCOMPLETE] }},
            {{ $orderStatisticData['statusCount'][Constants::ORDER_STATUS_CANCELLED] }}
        );
    </script>
@endpush
