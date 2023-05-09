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
            @include('pages.dashboard.components.overview-area', [
                'overviewItemCSSClass' => 'overview-item--c1',
                'overviewIconCSSClass' => 'zmdi zmdi-account-o',
                'overviewData' => $data['newCustomerCount'],
                'overviewTitle' => 'new memebers',
            ])
        </div>
        <div class="col-md-4">
            @include('pages.dashboard.components.overview-area', [
                'overviewItemCSSClass' => 'overview-item--c2',
                'overviewIconCSSClass' => 'zmdi zmdi-calendar-note',
                'overviewData' => $data['placedOrderCount'],
                'overviewTitle' => 'orders placed',
            ])
        </div>
        <div class="col-md-4">
            @include('pages.dashboard.components.overview-area', [
                'overviewItemCSSClass' => 'overview-item--c3',
                'overviewIconCSSClass' => 'zmdi zmdi-shopping-cart',
                'overviewData' => $data['soldItemCount'],
                'overviewTitle' => 'items sold',
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="au-card m-b-30 p-30">
                @if ($data['placedOrderCount'] > 0)
                    @include('pages.dashboard.components.order-statistics-section', [
                        'fromDate' => $data['fromDate'],
                        'toDate' => $data['toDate'],
                        'orderStatisticsData' => $data['orderStatisticsData'],
                    ])
                @else
                    <div>No data.</div>
                @endif
            </div>
        </div>
    </div>

    @if ($data['placedOrderCount'] > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="au-card m-b-30 p-30">
                    @include('pages.dashboard.components.category-statistics-section', [
                        'fromDate' => $data['fromDate'],
                        'toDate' => $data['toDate'],
                        'bestSellingCategories' => $data['catalogStatisticsData']['bestSellingCategories'],
                        'totalSoldQuantity' => $data['soldItemCount'],
                    ])
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($data['catalogStatisticsData']['bestSellingCategories'] as $bestSellingCategory)
                <div class="col-md-4">
                    <div class="au-card m-b-30 p-30">
                        @include('pages.dashboard.components.brand-by-category-statistics-section', [
                            'fromDate' => $data['fromDate'],
                            'toDate' => $data['toDate'],
                            'bestSellingCategory' => $bestSellingCategory,
                        ])
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
