<div class="au-card m-b-30">
    @if ($orderStatisticData)
        <div class="au-card-inner">
            <div class="order-chart-header m-b-40">
                <h3 class="title-2 ">Order Status</h3>
                <div class="order-chart-action-wrapper">
                    @include('shared.components.buttons.excel-button', [
                        'excelUrl' => route('dashboard.export.excel.order.details'),
                        'conditionFields' => [
                            'fromDate' => $fromDate,
                            'toDate' => $toDate,
                        ],
                    ])
                </div>
            </div>

            @include('pages.dashboard.components.order-status-chart', [
                'orderStatusCountArray' => $orderStatisticData['statusCount'],
            ])
        </div>
    @else
        <div>No data.</div>
    @endif
</div>
