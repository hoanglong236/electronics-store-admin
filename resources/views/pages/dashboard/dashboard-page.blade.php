@extends('shared.layouts.catalog-layout')

@section('container-content')
    <div class="row">
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1">Dashboard</h2>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="white-bg-wrapper">
                Export section
            </div>
        </div>
    </div>

    @php
        $dashboardData = $data['dashboardData'];
    @endphp

    <div class="row mt-4">
        <div class="col-md-3">
            @include('pages.dashboard.components.overview-panel', [
                'imageUrl' => asset('assets/images/icon/customer.png'),
                'title' => 'New Customer',
                'currentData' => $dashboardData['newCustomersCount'],
            ])
        </div>
        <div class="col-md-3">
            @include('pages.dashboard.components.overview-panel', [
                'imageUrl' => asset('assets/images/icon/shopping-bag.png'),
                'title' => 'Orders',
                'currentData' => $dashboardData['orderQty'],
            ])
        </div>
        <div class="col-md-3">
            @include('pages.dashboard.components.overview-panel', [
                'imageUrl' => asset('assets/images/icon/revenue.png'),
                'title' => 'Revenue',
                'currentData' => $dashboardData['revenue'],
            ])
        </div>
        <div class="col-md-3">
            @include('pages.dashboard.components.overview-panel', [
                'title' => 'Updating feature',
            ])
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="white-bg-wrapper m-b-30 p-30">
                @if ($dashboardData['orderQty'] > 0)
                    @include('pages.dashboard.components.payment-channel-section', [
                        'orderQtyByPaymentMethods' => $dashboardData['orderQtyByPaymentMethods'],
                    ])
                @else
                    <div>No data.</div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="white-bg-wrapper m-b-30 p-30">
                <div>No data.</div>
            </div>
        </div>
    </div>
@endsection
