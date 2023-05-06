@php
    $totalSoldQuantity = $bestSellingCategory['soldQuantity'];
    $othersSoldQuantity = $totalSoldQuantity;

    $chartElementId = 'bestSellingBrandChart' . $bestSellingCategory['id'];
    $chartTitle = 'Best-selling Brands In ' . $bestSellingCategory['name'];
    $drawChartParamsString = "'{$chartElementId}', '{$chartTitle}', ";

    $brandChartElements = [];

    foreach ($bestSellingCategory['bestSellingBrands'] as $bestSellingBrand) {
        $othersSoldQuantity -= $bestSellingBrand['soldQuantity'];
        $drawChartParamsString .= "'" . $bestSellingBrand['name'] . "', " . $bestSellingBrand['soldQuantity'] . ', ';
        $brandChartElements[] = [
            'label' => $bestSellingBrand['name'],
            'value' => $bestSellingBrand['soldQuantity'],
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
        <canvas id="bestSellingBrandChart{{ $bestSellingCategory['id'] }}"></canvas>
    </div>
</div>

@push('scripts')
    @once
        <script src="{{ asset('assets/js/best-selling-brands-chart.js') }}"></script>
    @endonce
    <script>
        drawBestSellingBrandChart({!! $drawChartParamsString !!});
    </script>
@endpush
