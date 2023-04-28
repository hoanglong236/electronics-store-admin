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
            @include('pages.dashboard.components.dashboard-search-form')
        </div>
    </div>

    <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
            @include('pages.dashboard.components.total-account-overview-area')
        </div>
        <div class="col-sm-6 col-lg-3">
            @include('pages.dashboard.components.items-solid-overview-area')
        </div>
        <div class="col-sm-6 col-lg-3">
            @include('pages.dashboard.components.order-placed-overview-area')
        </div>
        <div class="col-sm-6 col-lg-3">
            @include('pages.dashboard.components.total-earning-overview-area')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="au-card m-b-30">
                <div class="au-card-inner">
                    <div class="order-chart-header m-b-40">
                        <h3 class="title-2 ">Order Chart</h3>
                        <div class="order-chart-action-wrapper">
                            @include('shared.components.buttons.excel-button', [
                                'excelUrl' => '',
                            ])
                        </div>
                    </div>

                    @include('pages.dashboard.components.order-chart', [
                        'orderStatisticData' => $data['orderStatisticData'],
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
