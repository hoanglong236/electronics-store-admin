@extends('shared.layouts.catalog-layout')

@section('container')
    <a href="{{ route('catalog.category.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong>Create Category</strong>
                </div>
                <form action="{{ route('catalog.category.create.handler') }}" method="post" enctype="multipart/form-data"
                    class="form-horizontal">
                    @csrf
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
                            <label for="categoryName" class="form-control-label">Category name</label>
                            <input id="categoryName" type="text" name="name" class="form-control" required>
                            @error('name')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="categoryIcon" class="form-control-label">Category icon</label>
                            <input id="categoryIcon" type="file" name="icon" class="form-control-file">
                            @error('icon')
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
