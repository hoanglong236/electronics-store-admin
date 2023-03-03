@extends('layouts.base-layout')

@section('container')
    <h1>Product</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Product</div>
                <div class="card-body">
                    <form action="{{ route('catalog.product.update.handler', $product->id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label mb-1">Product ID</label>
                            <input name="id" type="text" value="{{ $product->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label mb-1">Category Name</label>
                            <select name="categoryId" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id === $product->category_id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label mb-1">Brand Name</label>
                            <select name="brandId" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected($brand->id === $product->brand_id)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Product Name</label>
                            <input name="name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $product->name }}" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mainImage" class="control-label mb-1">Select new image</label>
                            <input name="mainImage" type="file" class="form-control-file" aria-required="true"
                                aria-invalid="false">
                            @error('mainImage')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div><br>
                        <button type="submit" class="btn btn-lg btn-info btn-block mt-3 mb-1">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- END DATA TABLE-->
    <a href="{{ route('catalog.product.index') }}">
        <button type="button" class="btn btn-success">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>
@endsection
