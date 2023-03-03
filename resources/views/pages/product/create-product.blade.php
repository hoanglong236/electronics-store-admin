@extends('layouts.base-layout')

@section('container')
    <h1>Product</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Product</div>
                <div class="card-body">
                    <form action="{{ route('catalog.product.create.handler') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="" class="control-label mb-1">Category Name</label>
                            <select name="categoryId" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                <option value="null">
                                    Select a category
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label mb-1">Brand Name</label>
                            <select name="brandId" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                <option value="null">
                                    Select a brand
                                </option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Product Name</label>
                            <input name="name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mainImage" class="control-label mb-1">Main Image</label>
                            <input name="mainImage" type="file" class="form-control-file"  aria-required="true"
                                aria-invalid="false" required>
                            @error('mainImage')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div><br>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
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
