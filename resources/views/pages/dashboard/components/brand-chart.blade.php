@php
    $totalSoldQuantity = $category->soldQuantity;
    $othersSoldQuantity = $totalSoldQuantity;

    $chartElementId = 'bestSellingBrandsChart' . $category->id;
    $chartTitle = 'Best-selling Brands In ' . $category->name;
    $drawChartParamsString = "'{$chartElementId}', '{$chartTitle}', ";

    $brandChartElements = [];

    foreach ($brands as $brand) {
        $othersSoldQuantity -= $brand->soldQuantity;
        $drawChartParamsString .= "'" . $brand->name . "', " . $brand->soldQuantity . ', ';
        $brandChartElements[] = [
            'label' => $brand->name,
            'value' => $brand->soldQuantity,
        ];
    }
    if ($othersSoldQuantity > 0) {
        $drawChartParamsString .= "'Others', " . $othersSoldQuantity;
        $brandChartElements[] = [
            'label' => 'Others',
            'value' => $othersSoldQuantity,
        ];
    }
@endphp

<div class="row">
    <div class="col-md-12 mb-4">
        @include('shared.components.chart-legend-table', [
            'notEmptyChartElements' => $brandChartElements,
            'chartElementCount' => Constants::BEST_SELLING_BRANDS_LIMIT + 1,
        ])
    </div>
    <div class="col-md-12">
        <canvas id="bestSellingBrandsChart{{ $category->id }}"></canvas>
    </div>
</div>

@push('scripts')
    @once
        <script src="{{ asset('assets/js/best-selling-brands-chart.js') }}"></script>
    @endonce
    <script>
        drawBestSellingBrandsChart({!! $drawChartParamsString !!});
    </script>
@endpush
