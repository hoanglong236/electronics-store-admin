@extends('shared.layouts.catalog-layout')

@section('container-content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-5 mb-4">Order</h2>
            @if (Session::has(Constants::ACTION_SUCCESS))
                @include('shared.components.action-success-label', [
                    'succeeMessage' => Session::get(Constants::ACTION_SUCCESS),
                ])
            @endif

            <div class="white-bg-wrapper">
                @include('pages.order.components.order-filters-bar', [
                    'orderIdKeyword' => $data['orderIdKeyword'],
                    'phoneOrEmailKeyword' => $data['phoneOrEmailKeyword'],
                    'deliveryAddressKeyword' => $data['deliveryAddressKeyword'],
                    'statusFilter' => $data['statusFilter'],
                    'paymentMethodFilter' => $data['paymentMethodFilter'],
                    'sortField' => $data['sortField'],
                    'orderFilterUrl' => route('manage.order.filter'),
                ])
            </div>
        </div>
    </div>

    <div class="row m-t-20">
        <div class="col-md-12">
            <div class="export-buttons-wrapper text-right d-flex-center-space-between-wrap">
                <div class="export-title">Export</div>
                @include('shared.components.buttons.csv-button', [
                    'conditionFields' => [
                        'orderIdKeyword' => $data['orderIdKeyword'],
                        'phoneOrEmailKeyword' => $data['phoneOrEmailKeyword'],
                        'deliveryAddressKeyword' => $data['deliveryAddressKeyword'],
                        'statusFilter' => $data['statusFilter'],
                        'paymentMethodFilter' => $data['paymentMethodFilter'],
                        'sortField' => $data['sortField'],
                    ],
                    'csvUrl' => route('manage.order.filter-export-csv'),
                ])
            </div>
        </div>
    </div>

    <div class="row m-t-20">
        <div class="col-md-12">
            @include('pages.order.components.order-table', [
                'orders' => $data['orders'],
                'nextSelectableStatusMap' => $data['nextSelectableStatusMap'],
            ])
        </div>
    </div>

    @include('shared.components.pagination-nav', ['paginator' => $data['paginator']])
@endsection
