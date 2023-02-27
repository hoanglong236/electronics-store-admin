@extends('admin.layout')

@section('container')
    <h1>Product</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Product</div>
                <div class="card-body">
                    <form action="{{ route('admin.product.add_product_handle') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="category_id" class="control-label mb-1">Category Name</label>
                            <select name="category_id" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                <option value="">Please select a category</option>
                                @foreach ($category_data as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand_id" class="control-label mb-1">Brand Name</label>
                            <select name="brand_id" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                <option value="">Please select a brand</option>
                                @foreach ($brand_data as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_name" class="control-label mb-1">Product Name</label>
                            <input name="product_name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" required>
                            @error('product_name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="product_slug" class="control-label mb-1">Product Slug</label>
                            <input name="product_slug" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" required>
                            @error('product_slug')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="product_main_image" class="control-label mb-1">Product Image</label>
                            <input name="product_main_image" type="file" class="form-control-file"  aria-required="true"
                                aria-invalid="false" required>
                            @error('product_main_image')
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
    <a href="{{ route('admin.product') }}">
        <button type="button" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z" />
            </svg>
            &nbsp;Back
        </button>
    </a>
@endsection
