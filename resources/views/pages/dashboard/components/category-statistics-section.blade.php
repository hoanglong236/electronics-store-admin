<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="title-2 ">Best-selling Category Statistics</h3>
        <div class="chart-action-wrapper">
            @include('shared.components.buttons.excel-button', [
                'excelUrl' => route('dashboard.category-statistics.export-excel'),
                'conditionFields' => [
                    'fromDate' => $fromDate,
                    'toDate' => $toDate,
                ],
            ])
        </div>
    </div>

    @include('pages.dashboard.components.category-chart', [
        'totalSoldQuantity' => $totalSoldQuantity,
        'categoryInfoArray' => $bestSellingCategories
    ])
</div>
