@extends('admin.layout')

@section('container')
    <h1>Product</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Product</div>
                <div class="card-body">
                    <form action="{{ route('admin.product.update_product_handle') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label mb-1">Product ID</label>
                            <input name="id" type="text" value="{{ $product->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="control-label mb-1">Category Name</label>
                            <select name="category_id" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                @foreach ($category_data as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == $product->category_id) selected @endif>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand_id" class="control-label mb-1">Brand Name</label>
                            <select name="brand_id" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                @foreach ($brand_data as $brand)
                                    <option value="{{ $brand->id }}" @if ($brand->id == $product->brand_id) selected @endif>
                                        {{ $brand->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_name" class="control-label mb-1">Product Name</label>
                            <input name="product_name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $product->product_name }}" required>
                            @error('product_name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="product_slug" class="control-label mb-1">Product Slug</label>
                            <input name="product_slug" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $product->product_slug }}" required>
                            @error('product_slug')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="" class="control-label mb-1">Update Product Image?</label>
                                    <div class="form-check form-control" style="border-style: none">
                                        <input id="update_image_radio" class="form-check-input" type="radio"
                                            name="is_product_image_update_radio" value="yes">
                                        <label class="form-check-label" for="is_product_image_update_radio">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="" class="control-label mb-1"><br></label>
                                    <div class="form-check form-control" style="border-style: none">
                                        <input id="not_update_image_radio" class="form-check-input" type="radio"
                                            name="is_product_image_update_radio" value="no" checked>
                                        <label class="form-check-label" for="is_product_image_update_radio">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_main_image" class="control-label mb-1">Product Image</label>
                            <input id="product_image_field" name="product_main_image" type="file" class="form-control-file" aria-required="true"
                                aria-invalid="false" disabled required>
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
    <script>
        var update_image_radio = document.getElementById('update_image_radio');
        var not_update_image_radio = document.getElementById('not_update_image_radio');
        var product_image_field = document.getElementById('product_image_field');

        update_image_radio.addEventListener('click', function() {
            product_image_field.removeAttribute('disabled')
        })

        not_update_image_radio.addEventListener('click', function() {
            product_image_field.setAttribute('disabled', 'disabled');
            product_image_field.value = '';
        })
    </script>
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
