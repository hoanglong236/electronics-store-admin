@extends('admin.layout')

@section('container')
    <h1>Product Details</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            {{-- display product infomation --}}
            <div class="card">
                <div class="card-header">Product Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id" class="control-label mb-1">Product ID</label>
                        <input name="id" type="text" value="{{ $product->id }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="control-label mb-1">Category Name</label>
                        @foreach ($category_data as $category)
                            @if ($category->id == $product->category_id)
                                <input name="category_id" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false" value={{ $category->category_name }} readonly>
                                @break
                            @endif
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="brand_id" class="control-label mb-1">Brand Name</label>
                        @foreach ($brand_data as $brand)
                            @if ($brand->id == $product->brand_id)
                                <input name="brand_id" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false" value={{ $brand->brand_name }} readonly>
                                @break
                            @endif
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="product_name" class="control-label mb-1">Product Name</label>
                        <input name="product_name" type="text" class="form-control" aria-required="true"
                            aria-invalid="false" value="{{ $product->product_name }}" readonly>
                        @error('product_name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product_slug" class="control-label mb-1">Product Slug</label>
                        <input name="product_slug" type="text" class="form-control" aria-required="true"
                            aria-invalid="false" value="{{ $product->product_slug }}" readonly>
                        @error('product_slug')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>                
                    <div class="form-group">
                        <label for="product_main_image" class="control-label mb-1">Product Image</label><br><br>
                        <div class="product_image_container">
                            <img class="product_image"
                                src="{{ asset('/storage/product_image/' . $product->product_main_image) }}">
                        </div>
                    </div><br>
                </div>
            </div>
            {{-- display product image --}}
            <div class="table-responsive table--no-card m-b-30 product_table">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product ID</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($image_data as $product_image)
                            <tr>
                                <td class="align-middle">{{ $product_image->id }}</td>
                                <td class="align-middle">{{ $product_image->product_id }}</td>
                                <td class="align-middle">
                                    <div class="product_image_container">
                                        <img class="product_image"
                                            src="{{ asset('/storage/product_image/' . $product_image->image) }}">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.product_detail.delete_product_image', [$product_image->id]) }}"><button
                                            type="button" class="btn btn-danger btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.product_detail.add_product_images', [$product->id]) }}">
                <button type="button" class="btn btn-success">Add Images</button>
            </a><br><br>
            {{-- display product details --}}
            @if ($detail_data->isNotEmpty())
                @foreach ($detail_data as $product_detail)
                    <div class="card">
                        <div class="card-header">Product Option</div>
                        <div class="card-body">
                            @if ($product_detail->product_option_name_1 != null) 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="product_option_name_1" class="control-label mb-1">Option Name 1</label>
                                            <input name="product_option_name_1" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false"
                                                value={{ $product_detail->product_option_name_1 }} readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="product_option_value_1" class="control-label mb-1">Option Value
                                                1</label>
                                            <input name="product_option_value_1" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false"
                                                value="{{ $product_detail->product_option_value_1 }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($product_detail->product_option_name_2 != null) 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="product_option_name_2" class="control-label mb-1">Option Name 2</label>
                                            <input name="product_option_name_2" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false"
                                                value={{ $product_detail->product_option_name_2 }} readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="product_option_value_2" class="control-label mb-1">Option Value
                                                2</label>
                                            <input name="product_option_value_2" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false"
                                                value="{{ $product_detail->product_option_value_2 }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($product_detail->product_option_name_3 != null) 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="product_option_name_3" class="control-label mb-1">Option Name 3</label>
                                            <input name="product_option_name_3" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false"
                                                value={{ $product_detail->product_option_name_3 }} readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="product_option_value_3" class="control-label mb-1">Option Value
                                                3</label>
                                            <input name="product_option_value_3" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false"
                                                value="{{ $product_detail->product_option_value_3 }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="SKU" class="control-label mb-1">SKU</label>
                                        <input name="SKU" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value="{{ $product_detail->SKU }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="quantity" class="control-label mb-1">Quantity</label>
                                        <input name="quantity" type="number" min="0" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ $product_detail->quantity }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="price" class="control-label mb-1">Price ($)</label>
                                        <input name="price" type="number" min="0" step="0.01" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ $product_detail->price }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="discount_percent" class="control-label mb-1">Discount Percent (%)</label>
                                        <input name="discount_percent" type="number" min="0" max="100" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ $product_detail->discount_percent }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="warranty_period" class="control-label mb-1">Warranty Period</label>
                                        <input name="warranty_period" type="number" min="1" max="60" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ $product_detail->warranty_period }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="short_desc" class="control-label mb-1">Short Description</label>
                                <textarea name="short_desc" class="form-control" aria-required="true"
                                    aria-invalid="false" rows="4" readonly>{{ $product_detail->short_desc }}</textarea>
                            </div>
                        </div>
                    </div>
                    @if ($product_detail->product_option_name_3 == null)
                        <a href="{{ route('admin.product_detail.add_product_detail_option', [$product_detail->id]) }}">
                            <button type="button" class="btn btn-success">Add Option</button>
                        </a>
                    @endif
                    @if ($product_detail->product_option_name_1 != null)
                        <a href="{{ route('admin.product_detail.add_product_detail_option_value', [$product_detail->id]) }}">
                            <button type="button" class="btn btn-success">Add Product Detail Option Value</button>
                        </a>
                    @endif
                    <a href="{{ route('admin.product_detail.update_product_detail', [$product_detail->id]) }}">
                        <button type="button" class="btn btn-success">Update Product Detail</button>
                    </a>
                    <a href="{{ route('admin.product_detail.delete_product_detail_option', [$product_detail->id]) }}">
                        <button type="button" class="btn btn-success">Delete Option</button>
                    </a><br><br>
                @endforeach
            @else
                <a href="{{ route('admin.product_detail.add_product_detail', [$product->id]) }}">
                    <button type="button" class="btn btn-success">Add Details</button>
                </a>
            @endif
        </div>
        <!-- END DATA TABLE-->
    </div>
    <!-- END DATA TABLE-->
    {{-- js for alert (sweet alert 2) --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var has_alert = '{{ Session::has('alert') }}';
        if (has_alert) {
            var alert_message = '{{ Session::get('alert') }}';
            if (alert_message.indexOf("Error") == -1) {
                Swal.fire(
                    'Successfully!',
                    alert_message,
                    'success'
                )
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: $alert_message,
                })
            }
        }
    </script>
    <br>
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
