@php
    $othersSoldQuantity = $totalSoldQuantity;
    $drawChartParamsString = "'{$chartElementId}', '{$chartTitle}', ";
    $brandChartElements = [];

    foreach ($brandInfoArray as $brandInfo) {
        $othersSoldQuantity -= $brandInfo['soldQuantity'];
        $drawChartParamsString .= "'" . $brandInfo['name'] . "', " . $brandInfo['soldQuantity'] . ', ';
        $brandChartElements[] = [
            'label' => $brandInfo['name'],
            'value' => $brandInfo['soldQuantity'],
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
        <canvas id="{{ $chartElementId }}"></canvas>
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
