<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="sm-title-2">{{ $category->name }} Statistic</h3>
    </div>

    @include('pages.dashboard.components.best-selling-brands-chart', [
        'category' => $category,
        'brands' => $brands
    ])
</div>
