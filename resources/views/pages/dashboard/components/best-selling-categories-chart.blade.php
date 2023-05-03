@php
    $otherQuantity = $totalQuantity;
    foreach ($categories as $category) {
        $otherQuantity -= $category->quantity;
    }
@endphp

<div class="row">
    <div class="col-md-4">
        <table class="table order-chart-legend-table">
            <tbody>
                @foreach ($categories as $index => $category)
                    <tr>
                        <td><span class="dot dot--custom-{{ $index + 1 }}"></span></td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->totalQuantity }}</td>
                        <td>{{ round(($category->totalQuantity / $totalQuantity) * 100, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="chart-legend-explain-wrapper my-5">
        </div>
    </div>
    <div class="col-md-8">
        <canvas id="bestSellingCategoriesChart"></canvas>
    </div>
</div>

@push('scripts')
    {{-- <script src="{{ asset('assets/js/best-selling-categories-chart.js') }}"></script>
    <script>
        drawBestSellingCategoriesChart(
            {{ $incompleteOrderCount }},
            {{ $orderStatusCountArray[Constants::ORDER_STATUS_COMPLETED] }},
            {{ $orderStatusCountArray[Constants::ORDER_STATUS_CANCELLED] }}
        );
    </script> --}}
@endpush
