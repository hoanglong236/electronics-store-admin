@extends('shared.layouts.catalog-layout')

@section('container')
    <a href="{{ route('catalog.product.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-8">
            @include('pages.product.components.create-product-form')
        </div>
    </div>
@endsection
