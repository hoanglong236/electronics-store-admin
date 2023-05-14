<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="sm-title-2">{{ $bestSellingCategory['name'] }}</h3>
    </div>

    @include('pages.dashboard.components.brand-by-category-chart', [
        'bestSellingCategory' => $bestSellingCategory,
    ])
</div>
