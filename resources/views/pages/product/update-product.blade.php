@extends('layouts.catalog-layout')

@section('container')
    <a href="{{ route('catalog.product.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong>Create Product</strong>
                </div>
                <form action="{{ route('catalog.product.update.handler', $product->id) }}" method="post"
                    enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="category" class="form-control-label">Category</label>
                            <select id="category" name="categoryId" class="form-control">
                                @foreach ($categoryNameMap as $key => $value)
                                    <option value="{{ $key }}" @selected($key === $product->category_id)>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoryId')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand" class="form-control-label">Brand</label>
                            <select id="brand" name="brandId" class="form-control">
                                @foreach ($brandNameMap as $key => $value)
                                    <option value="{{ $key }}" @selected($key === $product->brand_id)>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brandId')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="productName" class="form-control-label">Name</label>
                            <input id="productName" type="text" name="name" value="{{ $product->name }}"
                                class="form-control" required>
                            @error('name')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="productMainImage" class="form-control-label">New main image?</label>
                            <input id="productMainImage" type="file" name="mainImage" class="form-control-file">
                            @error('mainImage')
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
