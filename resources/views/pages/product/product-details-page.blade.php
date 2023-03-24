@extends('shared.layouts.catalog-layout')

@section('container')
    @include('shared.components.back-button', ['backUrl' => route('catalog.product.index')])

    <div class="row mt-4">
        <div class="col-lg-8">
            @include('pages.product.components.product-details-table')
        </div>
        <div class="col-lg-4">
            <div class="card card-radius">
                <img class="card-img-top card-image--custom-square" src="{{ asset('storage/' . $product->main_image_path) }}"
                    alt="Card image cap">
            </div>
        </div>
    </div>

    <h4 class="title-5 mt-1 mb-4">Product sliders</h4>
    @if (Session::has(Constants::ACTION_SUCCESS))
        @include('shared.components.action-success-label', [
            'succeeMessage' => Session::get(Constants::ACTION_SUCCESS),
        ])
    @endif

    <div class="row mt-4">
        <div class="col-lg-8">
            @include('pages.product.components.product-images-create-card')
            @include('pages.product.components.product-images-table')
        </div>
        <div class="col-lg-4">
            @if (count($productImages) > 0)
                @include('pages.product.components.product-images-slider')
            @endif
        </div>
    </div>
@endsection
