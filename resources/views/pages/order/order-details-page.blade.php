@extends('shared.layouts.catalog-layout')

@section('container-content')
    @include('shared.components.buttons.back-button', [
        'backUrl' => route('manage.order.index'),
    ])

    <div class="row mt-4">
        <div class="col-md-9">
            @include('pages.order.components.order-items-table', [
                'orderItems' => $data['orderItems'],
            ])
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-9">
            @include('pages.order.components.customer-info-table', [
                'customerInfo' => [
                    'id' => $data['order']->customer_id,
                    'name' => $data['order']->customer_name,
                    'phone' => $data['order']->customer_phone,
                    'email' => $data['order']->customer_email,
                    'deliveryAddress' => $data['order']->delivery_address,
                ],
            ])
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-9">
            @include('pages.order.components.order-info-table', [
                'orderInfo' => [
                    'id' => $data['order']->id,
                    'totalAmount' => $data['order']->total,
                    'status' => $data['order']->status,
                    'paymentMethod' => $data['order']->payment_method,
                    'createdAt' => $data['order']->created_at,
                    'updatedAt' => $data['order']->updated_at,
                ],
            ])
        </div>
    </div>
@endsection
