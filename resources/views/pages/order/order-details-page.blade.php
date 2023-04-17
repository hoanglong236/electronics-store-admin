@extends('shared.layouts.catalog-layout')

@section('container-content')
    @include('shared.components.buttons.back-button', [
        'backUrl' => route('manage.order.index'),
    ])

    <div class="row mt-4">
        <div class="col-md-9">
            @include('pages.order.components.order-items-table', [
                'customOrderItems' => $data['customOrderItems'],
            ])
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-9">
            @include('pages.order.components.customer-info-table', [
                'customerInfo' => [
                    'id' => $data['customOrder']->customer_id,
                    'name' => $data['customOrder']->customer_name,
                    'phone' => $data['customOrder']->customer_phone,
                    'email' => $data['customOrder']->customer_email,
                    'deliveryAddress' => $data['customOrder']->delivery_address,
                ],
            ])
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-9">
            @include('pages.order.components.order-info-table', [
                'orderInfo' => [
                    'id' => $data['customOrder']->id,
                    'totalAmount' => $data['customOrder']->total,
                    'status' => $data['customOrder']->status,
                    'paymentMethod' => $data['customOrder']->payment_method,
                    'createdAt' => $data['customOrder']->created_at,
                    'updatedAt' => $data['customOrder']->updated_at,
                ],
            ])
        </div>
    </div>
@endsection
