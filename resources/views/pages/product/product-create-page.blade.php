@extends('shared.layouts.catalog-layout')

@section('container')
    @include('shared.components.back-button', ['backUrl' => route('catalog.product.index')])

    <div class="row mt-4">
        <div class="col-lg-8">
            @include('pages.product.components.product-create-card')
        </div>
    </div>
@endsection
