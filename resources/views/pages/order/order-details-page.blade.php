@extends('shared.layouts.catalog-layout')

@section('container')
    @include('shared.components.buttons.back-button', [
        'backUrl' => route('manage.order.index'),
    ])

    <div class="row mt-4 mb-4">
        <div class="col-lg-8">
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
        <div class="col-lg-8">
            @include('pages.order.components.order-items-table', [
                'customOrderItems' => $data['customOrderItems'],
            ])
        </div>
        <div class="col-lg-4">
            @include('pages.order.components.order-info-table', [
                'orderInfo' => [
                    'id' => $data['customOrder']->id,
                    'itemCount' => count($data['customOrderItems']),
                    'totalAmount' => $data['customOrder']->total,
                    'status' => $data['customOrder']->status,
                    'createdAt' => $data['customOrder']->created_at,
                    'updatedAt' => $data['customOrder']->updated_at,
                ],
            ])
        </div>
    </div>
@endsection
