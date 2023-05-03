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
        <div class="col-md-12">
            @include('pages.dashboard.components.order-section', [
                'fromDate' => $data['fromDate'],
                'toDate' => $data['toDate'],
                'orderStatisticData' => $data['orderStatisticData'],
            ])
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            @include('pages.dashboard.components.best-selling-products-section', [
                'fromDate' => $data['fromDate'],
                'toDate' => $data['toDate'],
            ])
        </div>
        <div class="col-md-4">
            @include('pages.dashboard.components.best-selling-categories-section', [
                'fromDate' => $data['fromDate'],
                'toDate' => $data['toDate'],
            ])
        </div>
        <div class="col-md-4">
            @include('pages.dashboard.components.best-selling-brands-section', [
                'fromDate' => $data['fromDate'],
                'toDate' => $data['toDate'],
            ])
        </div>
    </div>
@endsection
