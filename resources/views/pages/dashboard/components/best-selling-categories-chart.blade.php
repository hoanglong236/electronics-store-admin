@php
    $othersSoldQuantity = $totalSoldQuantity;
    $drawChartParams = '';

    foreach ($categories as $category) {
        $othersSoldQuantity -= $category->soldQuantity;
        $drawChartParams .= "'" . $category->name . "', " . $category->soldQuantity . ', ';
    }
    if ($othersSoldQuantity > 0) {
        $drawChartParams .= "'Others', " . $othersSoldQuantity;
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
                        <td>{{ $category->soldQuantity }}</td>
                        <td>{{ round(($category->soldQuantity / $totalSoldQuantity) * 100, 2) }}%</td>
                    </tr>
                @endforeach
                @if ($othersSoldQuantity > 0)
                    <tr>
                        <td><span class="dot dot--custom-{{ Constants::BEST_SELLING_CATEGORIES_LIMIT + 1 }}"></span></td>
                        <td>Others</td>
                        <td>{{ $othersSoldQuantity }}</td>
                        <td>{{ round(($othersSoldQuantity / $totalSoldQuantity) * 100, 2) }}%</td>
                    </tr>
                @endif
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
    <script src="{{ asset('assets/js/best-selling-categories-chart.js') }}"></script>
    <script>
        drawBestSellingCategoriesChart({!! $drawChartParams !!});
    </script>
@endpush
