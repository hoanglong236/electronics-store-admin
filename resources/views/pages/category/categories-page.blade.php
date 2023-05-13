@extends('shared.layouts.catalog-layout')

@section('container-content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-5 mb-4">Category</h2>
            @if (Session::has(Constants::ACTION_SUCCESS))
                @include('shared.components.action-success-label', [
                    'succeeMessage' => Session::get(Constants::ACTION_SUCCESS),
                ])
            @endif
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    @include('shared.components.search-bar', [
                        'searchFormUrl' => route('catalog.category.search'),
                        'searchKeyword' => $data['searchKeyword'],
                    ])
                </div>
                <div class="table-data__tool-right">
                    @include('shared.components.buttons.add-button', [
                        'addUrl' => route('catalog.category.create'),
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="row m-t-10">
        <div class="col-md-12">
            @include('pages.category.components.categories-table', [
                'categories' => $data['categories'],
                'categoryIdNameMap' => $data['categoryIdNameMap'],
            ])
        </div>
    </div>

    @include('shared.components.pagination-nav', ['paginator' => $data['paginator']])
@endsection
