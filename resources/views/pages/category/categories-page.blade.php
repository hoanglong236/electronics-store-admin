@extends('shared.layouts.catalog-layout')

@section('container')
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
                    @include('shared.components.dropdown-search-bar', [
                        'searchFormUrl' => route('catalog.category.search'),
                        'searchFieldMap' => $data['categorySearchFieldMap'],
                        'searchKeyword' => $data['searchKeyword'],
                        'searchField' => $data['searchField'],
                    ])
                </div>
                <div class="table-data__tool-right">
                    <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                        <select class="js-select2" name="type">
                            <option selected="selected">Export</option>
                            <option value="">Option 1</option>
                            <option value="">Option 2</option>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                    <a href="{{ route('catalog.category.create') }}">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i>add item
                        </button>
                    </a>
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
@endsection
