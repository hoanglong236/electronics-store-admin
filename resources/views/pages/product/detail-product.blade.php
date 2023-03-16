@extends('shared.layouts.catalog-layout')

@section('container')
    <a href="{{ route('catalog.product.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-8">
            @include('pages.product.components.product-detail-table')
        </div>
        <div class="col-lg-4">
            <div class="card card-radius">
                <img class="card-img-top card-image-custom--square" src="{{ asset('storage/' . $product->main_image_path) }}"
                    alt="Card image cap">
                <div class="card-body">
                    <h5>Main image</h5>
                </div>
            </div>
        </div>
    </div>

    <h4 class="title-5 mt-1 mb-4">Product sliders</h4>
    @if (Session::has(Constants::ACTION_SUCCESS))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success">Success</span>
            {{ Session::get(Constants::ACTION_SUCCESS) }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row mt-4">
        <div class="col-lg-8">
            @include('pages.product.components.create-product-images-form')

            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Image</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productImages as $key => $productImage)
                            @include('pages.product.components.product-image-item')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            @if (count($productImages) > 0)
                @include('pages.product.components.product-image-slider')
            @endif
        </div>
    </div>
@endsection
