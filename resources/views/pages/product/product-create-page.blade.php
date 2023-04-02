@extends('shared.layouts.catalog-layout')

@section('container-content')
    @include('shared.components.buttons.back-button', [
        'backUrl' => route('catalog.product.index'),
    ])

    <div class="row mt-4">
        <div class="col-lg-8">
            @include('pages.product.components.product-create-card', [
                'categoryIdNameMap' => $data['categoryIdNameMap'],
                'brandIdNameMap' => $data['brandIdNameMap'],
            ])
        </div>
    </div>
@endsection
