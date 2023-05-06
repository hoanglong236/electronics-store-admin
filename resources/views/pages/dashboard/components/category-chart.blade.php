@php
    // Require variables: $totalSoldQuantity, $categoryInfoArray
    $othersSoldQuantity = $totalSoldQuantity;
    $drawChartParamsString = '';
    $categoryChartElements = [];

    foreach ($categoryInfoArray as $categoryInfo) {
        $othersSoldQuantity -= $categoryInfo['soldQuantity'];
        $drawChartParamsString .= "'" . $categoryInfo['name'] . "', " . $categoryInfo['soldQuantity'] . ', ';
        $categoryChartElements[] = [
            'label' => $categoryInfo['name'],
            'value' => $categoryInfo['soldQuantity'],
        ];
    }
    if ($othersSoldQuantity > 0) {
        $drawChartParamsString .= "'Others', " . $othersSoldQuantity;
        $categoryChartElements[] = [
            'label' => 'Others',
            'value' => $othersSoldQuantity,
        ];
    }
@endphp

<div class="row">
    <div class="col-md-4 mb-4">
        @include('shared.components.chart-legend-table', [
            'notEmptyChartElements' => $categoryChartElements,
            'chartElementCount' => count($categoryChartElements),
        ])
    </div>
    <div class="col-md-8">
        <canvas id="bestSellingCategoriesChart"></canvas>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/category-chart.js') }}"></script>
    <script>
        drawBestSellingCategoriesChart({!! $drawChartParamsString !!});
    </script>
@endpush
