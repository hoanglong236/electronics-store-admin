<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="chart-header-title">Best sellers</h3>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <canvas id="bestSellerBrands"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="bestSellerCategories"></canvas>
        </div>
    </div>

    <div class="m-t-40"></div>
    <canvas id="bestSellerProducts"></canvas>
</div>

@php
    $brandNames = [];
    $brandQtyData = [];
    foreach ($bestSellers['brands'] as $brand) {
        $brandNames[] = $brand->name;
        $brandQtyData[] = $brand->quantity;
    }
    $bestSellerBrandsDatasetPropertiesObjects = [
        (object) [
            'label' => 'Qty sold',
            'data' => $brandQtyData,
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $categoryNames = [];
    $categoryQtyData = [];
    foreach ($bestSellers['categories'] as $category) {
        $categoryNames[] = $category->name;
        $categoryQtyData[] = $category->quantity;
    }
    $bestSellerCategoriesDatasetPropertiesObjects = [
        (object) [
            'label' => 'Qty sold',
            'data' => $categoryQtyData,
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];

    $productNames = [];
    $productQtyData = [];
    foreach ($bestSellers['products'] as $product) {
        $productNames[] = $product->name;
        $productQtyData[] = $product->quantity;
    }
    $bestSellerProductsDatasetPropertiesObjects = [
        (object) [
            'label' => 'Qty sold',
            'data' => $productQtyData,
            'backgroundColor' => 'rgba(50, 125, 240, 0.6)',
            'borderColor' => 'rgb(50, 125, 240)',
        ],
    ];
@endphp

@pushOnce('scripts')
    <script src="{{ asset('assets/js/monthly-report/bar-chart.js') }}"></script>
@endPushOnce

@push('scripts')
    <script>
        drawMonthlyReportBarChart({
            canvasId: 'bestSellerBrands',
            chartLabels: {{ Js::from($brandNames) }},
            chartTitle: 'Best-seller Brands',
            datasetPropertiesObjects: {{ Js::from($bestSellerBrandsDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'bestSellerCategories',
            chartLabels: {{ Js::from($categoryNames) }},
            chartTitle: 'Best-seller Categories',
            datasetPropertiesObjects: {{ Js::from($bestSellerCategoriesDatasetPropertiesObjects) }}
        });

        drawMonthlyReportBarChart({
            canvasId: 'bestSellerProducts',
            chartLabels: {{ Js::from($productNames) }},
            chartTitle: 'Best-seller Products',
            datasetPropertiesObjects: {{ Js::from($bestSellerProductsDatasetPropertiesObjects) }}
        });
    </script>
@endpush
