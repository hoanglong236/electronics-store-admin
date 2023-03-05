@extends('layouts.catalog-layout')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-5 mb-4">Product</h2>
            @if (Session::has(Constants::ACTION_SUCCESS))
                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success">Success</span>
                    {{ Session::get(Constants::ACTION_SUCCESS) }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    <div class="rs-select2--light rs-select2--md">
                        <select class="js-select2" name="property">
                            <option selected="selected">All Properties</option>
                            <option value="">Option 1</option>
                            <option value="">Option 2</option>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                    <div class="rs-select2--light rs-select2--sm">
                        <select class="js-select2" name="time">
                            <option selected="selected">Today</option>
                            <option value="">3 Days</option>
                            <option value="">1 Week</option>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                    <button class="au-btn-filter">
                        <i class="zmdi zmdi-filter-list"></i>filters</button>
                </div>
                <div class="table-data__tool-right">
                    <a href="{{ route('catalog.product.create') }}">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i>add item
                        </button>
                    </a>
                    <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                        <select class="js-select2" name="type">
                            <option selected="selected">Export</option>
                            <option value="">Option 1</option>
                            <option value="">Option 2</option>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title mb-3">Product profile</strong>
                    </div>
                    <img class="card-img-top card-img-custom"
                        src="{{ asset('/storage' . '/' . $product->main_image_path) }}" alt="Product image">
                    <div class="card-body">
                        <div class="card-text">
                            <div>ID: {{ $product->id }}</div>
                            <div class="text-truncate">Category: {{ $categoryNameMap[$product->category_id] }}</div>
                            <div class="text-truncate">Brand: {{ $brandNameMap[$product->brand_id] }}</div>
                            <div class="text-truncate--two-line">Name: {{ $product->name }}</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="card-action-wrapper">
                            <div class="card-action-item">
                                {{-- <a href="{{ route('catalog.product.detail', [$product->id]) }}"> --}}
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="fa fa-info-circle"></i> Detail
                                </button>
                                {{-- </a> --}}
                            </div>
                            <div class="card-action-item">
                                <a href="{{ route('catalog.product.update', [$product->id]) }}">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="zmdi zmdi-edit"></i> Edit
                                    </button>
                                </a>
                            </div>
                            <div class="card-action-item">
                                <form method="post" action="{{ route('catalog.product.delete', [$product->id]) }}"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @php
        $firstPage = 1;
        $currentPage = $products->currentPage();
        $lastPage = $products->lastPage();
    @endphp
    <nav class="mt-3">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="{{ $products->url($firstPage) }}" @disabled($currentPage <= $firstPage)>
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="{{ $products->url(max($currentPage - 1, $firstPage)) }}"
                    @disabled($currentPage <= $firstPage)>
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>
            <li class="page-item page-item-center">
                <a class="page-link" href="{{ $products->url($currentPage) }}">
                    {{ $currentPage . '/' . $lastPage }}
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="{{ $products->url(min($currentPage + 1, $lastPage)) }}"
                    @disabled($currentPage >= $lastPage)>
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="{{ $products->url($lastPage) }}" @disabled($currentPage >= $lastPage)>
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
        </ul>
    </nav>
@endsection
