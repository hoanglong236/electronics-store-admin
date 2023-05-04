<div class="chart-wrapper">
    <div class="chart-header m-b-40">
        <h3 class="title-2 ">Category Statistic</h3>
        <div class="chart-action-wrapper">
            @include('shared.components.buttons.excel-button', [
                'excelUrl' => route('dashboard.category-statistic.export-excel'),
                'conditionFields' => [
                    'fromDate' => $fromDate,
                    'toDate' => $toDate,
                ],
            ])
        </div>
    </div>

    @include('pages.dashboard.components.best-selling-categories-chart')
</div>
