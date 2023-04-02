@extends('shared.layouts.catalog-layout')

@section('container-content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-5 mb-4">Product</h2>
            @if (Session::has(Constants::ACTION_SUCCESS))
                @include('shared.components.action-success-label', [
                    'succeeMessage' => Session::get(Constants::ACTION_SUCCESS),
                ])
            @endif
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    @include('shared.components.dropdown-search-bar', [
                        'searchFormUrl' => route('catalog.product.search'),
                        'searchKeyword' => $data['searchKeyword'],
                        'searchOptions' => $data['searchOptions'],
                        'currentSearchOption' => $data['currentSearchOption'],
                    ])
                </div>
                <div class="table-data__tool-right">
                    @include('shared.components.buttons.add-button', [
                        'addUrl' => route('catalog.product.create'),
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($data['products'] as $product)
            <div class="col-md-3">
                @include('pages.product.components.product-card')
            </div>
        @empty
            <div class="col-md-3">
                <span>No product found.</span>
            </div>
        @endforelse
    </div>

    @include('shared.components.pagination-nav', ['paginator' => $data['products']])
@endsection
