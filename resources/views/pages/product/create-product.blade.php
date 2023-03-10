@extends('shared.layouts.catalog-layout')

@section('container')
    <a href="{{ route('catalog.product.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <strong>Create Product</strong>
                </div>
                <form action="{{ route('catalog.product.create.handler') }}" method="post" enctype="multipart/form-data"
                    class="form-horizontal">
                    @csrf
                    <div class="card-body card-block">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="category" class="form-control-label">Category</label>
                                    <select id="category" name="categoryId" class="form-control">
                                        @foreach ($categoryNameMap as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('categoryId')
                                        <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="brand" class="form-control-label">Brand</label>
                                    <select id="brand" name="brandId" class="form-control">
                                        @foreach ($brandNameMap as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('brandId')
                                        <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productName" class="form-control-label">Name</label>
                            <input id="productName" type="text" name="name" class="form-control" required>
                            @error('name')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="productPrice" class="form-control-label">Price ($)</label>
                                    <input id="productPrice" type="number" min="0" name="price"
                                        class="form-control" required>
                                    @error('price')
                                        <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="productDiscountPercent" class="form-control-label">Discount percent
                                        (%)</label>
                                    <input id="productDiscountPercent" type="number" min="0" max="100"
                                        name="discountPercent" class="form-control" required>
                                    @error('price')
                                        <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="productQuantity" class="form-control-label">Quantity</label>
                                    <input id="productQuantity" type="number" min="0" name="quantity"
                                        class="form-control" required>
                                    @error('quantity')
                                        <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="productWarrantyPeriod" class="form-control-label">Warranty Period</label>
                                    <input id="productWarrantyPeriod" type="number" min="0" name="warrantyPeriod"
                                        class="form-control" required>
                                    @error('price')
                                        <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productDescription" class="form-control-label">Description</label>
                            <input id="productDescription" type="text" name="description" class="form-control" required>
                            @error('description')
                                <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="productMainImage" class="form-control-label">Main image</label>
                            <input id="productMainImage" type="file" name="mainImage" class="form-control-file" required>
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
