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
        <div class="col-lg-6">
            @include('pages.dashboard.components.order-chart', [
                'orderStatisticData' => $data['orderStatisticData'],
            ])
        </div>
        <div class="col-lg-6">
            <div class="au-card chart-percent-card">
                <div class="au-card-inner">
                    <h3 class="title-2 tm-b-5">char by %</h3>
                    <div class="row no-gutters">
                        <div class="col-xl-6">
                            <div class="chart-note-wrap">
                                <div class="chart-note mr-0 d-block">
                                    <span class="dot dot--blue"></span>
                                    <span>products</span>
                                </div>
                                <div class="chart-note mr-0 d-block">
                                    <span class="dot dot--red"></span>
                                    <span>services</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="percent-chart">
                                <canvas id="percent-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
