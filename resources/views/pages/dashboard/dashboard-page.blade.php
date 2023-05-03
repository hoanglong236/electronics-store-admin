@extends('shared.layouts.catalog-layout')

@section('container-content')
    <div class="row">
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1">overview</h2>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            @include('pages.dashboard.components.dashboard-search-form', [
                'fromDate' => $data['fromDate'],
                'toDate' => $data['toDate'],
                'searchUrl' => route('dashboard.search'),
            ])
        </div>
    </div>

    <div class="row m-t-25">
        <div class="col-md-4">
            @include('pages.dashboard.components.new-members-overview-area', [
                'overviewData' => $data['newCustomerCount'],
            ])
        </div>
        <div class="col-md-4">
            @include('pages.dashboard.components.order-placed-overview-area', [
                'overviewData' => $data['placedOrderCount'],
            ])
        </div>
        <div class="col-md-4">
            @include('pages.dashboard.components.items-solid-overview-area', [
                'overviewData' => $data['solidItemCount'],
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="au-card m-b-30">
                @if ($data['orderStatisticData'])
                    <div class="au-card-inner">
                        <div class="order-chart-header m-b-40">
                            <h3 class="title-2 ">Order Chart</h3>
                            <div class="order-chart-action-wrapper">
                                @include('shared.components.buttons.excel-button', [
                                    'excelUrl' => route('dashboard.export.excel'),
                                    'conditionFields' => [
                                        'fromDate' => $data['fromDate'],
                                        'toDate' => $data['toDate'],
                                    ],
                                ])
                            </div>
                        </div>

                        @include('pages.dashboard.components.order-chart', [
                            'orderStatisticData' => $data['orderStatisticData'],
                        ])
                    </div>
                @else
                    <div>No data.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
