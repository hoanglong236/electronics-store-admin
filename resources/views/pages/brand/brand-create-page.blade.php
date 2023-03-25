@extends('shared.layouts.catalog-layout')

@section('container')
    @include('shared.components.buttons.back-button', [
        'backUrl' => route('catalog.brand.index'),
    ])

    <div class="row mt-4">
        <div class="col-lg-6">
            @include('pages.brand.components.brand-create-card')
        </div>
    </div>
@endsection
