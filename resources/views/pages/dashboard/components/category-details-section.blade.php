<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="sm-title-2">{{ $bestSellingCategory['name'] }}</h3>
    </div>

    @include('pages.dashboard.components.brand-chart', [
        'chartElementId' => 'bestSellingBrandsChart' . $bestSellingCategory['id'],
        'chartTitle' => 'Best-selling Brands of ' . $bestSellingCategory['name'] . ' Chart',
        'totalSoldQuantity' => $bestSellingCategory['soldQuantity'],
        'brandInfoArray' => $bestSellingCategory['bestSellingBrands'],
    ])
</div>
