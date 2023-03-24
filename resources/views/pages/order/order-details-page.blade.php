@extends('shared.layouts.catalog-layout')

@section('container')
    @include('shared.components.back-button', ['backUrl' => route('manage.order.index')])

    <div class="row mt-4 mb-4">
        <div class="col-lg-9">
            @include('pages.order.components.customer-info-table', ['customerInfo' => [
                'id' => $customOrder->customer_id,
                'name' => $customOrder->customer_name,
                'phone' => $customOrder->customer_phone,
                'email' => $customOrder->customer_email,
                'deliveryAddress' => $customOrder->delivery_address,
            ]])
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-8">
            @include('pages.order.components.order-items-table')
        </div>
        <div class="col-lg-4">
            @include('pages.order.components.order-info-table', ['orderInfo' => [
                'id' => $customOrder->id,
                'itemCount' => count($customOrderItems),
                'totalAmount' => $customOrder->total,
                'status' => $customOrder->status,
                'createdAt' => $customOrder->created_at,
                'updatedAt' => $customOrder->updated_at,
            ]])
        </div>
    </div>
@endsection
