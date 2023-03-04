@extends('layouts.catalog-layout')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-5 mb-4">Category</h2>
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
                    <a href="{{ route('catalog.category.create') }}">
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

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    @if (isset($category->icon_path))
                                        <img class="icon-small" src="{{ asset('/storage' . '/' . $category->icon_path) }}"
                                            alt="{{ $category->name . ' icon' }}">
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ is_null($category->parent_id) ? '__' : $categoryNameMap[$category->parent_id] }}</td>
                                <td>
                                    <div class="card-action-wrapper--right">
                                        <div class="card-action-item">
                                            <a href="{{ route('catalog.category.update', [$category->id]) }}">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="card-action-item">
                                            <form method="post"
                                                action="{{ route('catalog.category.delete', [$category->id]) }}"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
