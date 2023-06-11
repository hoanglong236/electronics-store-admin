@extends('shared.layouts.catalog-layout')

@section('container-content')
    @include('shared.components.buttons.back-button', [
        'backUrl' => route('catalog.product.index'),
    ])

    @php
        $productDetails = $data['productDetails'];
    @endphp

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="white-bg-wrapper">
                @include('pages.product.components.product-details-area', [
                    'productInfo' => $productDetails['productInfo'],
                    'productImages' => $productDetails['images'],
                ])
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-6">
            @include('pages.product.components.product-images-table', [
                'mainImagePath' => $productDetails['productInfo']['mainImagePath'],
                'productImages' => $productDetails['images'],
                'productId' => $productDetails['productInfo']['id'],
            ])
        </div>
        <div class="col-sm-6">
            @include('pages.product.components.product-images-create-card', [
                'productId' => $productDetails['productInfo']['id'],
            ])
        </div>
    </div>
@endsection

@if (Session::has(Constants::ACTION_SUCCESS))
    <script>
        alert('{{ Session::get(Constants::ACTION_SUCCESS) }}');
    </script>
@endif
