@extends('shared.layouts.catalog-layout')

@section('container-content')
    @include('shared.components.buttons.back-button', [
        'backUrl' => route('manage.order.index'),
    ])

    <div class="row m-t-20">
        <div class="col-md-9">
            @include('pages.order.components.order-items-table', [
                'orderItems' => $data['orderDetails']['items'],
            ])
        </div>
    </div>

    <div class="row m-t-20">
        <div class="col-md-9">
            @include('pages.order.components.customer-info-table', [
                'customerInfo' => $data['orderDetails']['customer'],
            ])
        </div>
    </div>

    <div class="row m-t-20">
        <div class="col-md-9">
            @include('pages.order.components.order-info-table', [
                'orderInfo' => $data['orderDetails']['order'],
            ])
        </div>
    </div>
@endsection
