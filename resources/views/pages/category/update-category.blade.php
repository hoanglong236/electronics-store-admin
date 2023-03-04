@extends('layouts.catalog-layout')

@section('container')
    <a href="{{ route('catalog.category.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <strong>Update Category</strong>
                </div>
                <form action="{{ route('catalog.category.update.handler', $category->id) }}" method="post"
                    enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="parentCategoryId" class="form-control-label">Parent category</label>
                            <select id="parentCategoryId" name="parentId" class="form-control">
                                <option value="{{ Constants::NONE_VALUE }}">None</option>
                                @foreach ($categoryNameMap as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('parentId')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="categoryName" class=" form-control-label">Category name</label>
                            <input id="categoryName" type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                            @error('name')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="categoryLogo" class="form-control-label">New category logo?</label>
                            <input id="categoryLogo" type="file" name="logo" class="form-control-file">
                            @error('logo')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
