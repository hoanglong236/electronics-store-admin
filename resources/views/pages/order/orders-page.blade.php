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

            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    @include('shared.components.dropdown-search-bar', [
                        'searchFormUrl' => route('manage.order.search'),
                        'searchKeyword' => $data['searchKeyword'],
                        'searchOptions' => $data['searchOptions'],
                        'currentSearchOption' => $data['currentSearchOption'],
                    ])

                    @include('pages.order.components.filter-bar', [
                        'filterFormUrl' => route('manage.order.filter'),
                        'searchKeyword' => $data['searchKeyword'],
                        'searchOption' => $data['currentSearchOption'],
                        'statusFilters' => $data['statusFilters'],
                        'currentStatusFilter' => $data['currentStatusFilter'],
                        'paymentFilters' => $data['paymentFilters'],
                        'currentPaymentFilter' => $data['currentPaymentFilter'],
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="row m-t-10">
        <div class="col-md-12">
            @include('pages.order.components.order-table', [
                'customOrders' => $data['customOrders'],
                'nextSelectableStatusMap' => $data['nextSelectableStatusMap'],
            ])
        </div>
    </div>
@endsection
