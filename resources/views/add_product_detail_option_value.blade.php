@extends('admin.layout')

@section('container')
    <h1>Product Detail Options</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Product Detail Option Values</div>
                <div class="card-body">
                    <form action="{{ route('admin.product_detail.add_product_detail_option_value_handle') }}"
                        method="post">
                        @csrf
                        <div class="form-group">
                            <label for="product_id" class="control-label mb-1">Product ID</label>
                            <input name="product_id" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $product_detail->product_id }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="id" class="control-label mb-1">Product Detail ID</label>
                            <input name="id" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                value="{{ $product_detail->id }}" readonly>
                        </div>
                        @if ($product_detail->product_option_name_1 != null)
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="product_option_name_1" class="control-label mb-1">Option Name 1</label>
                                        <input name="product_option_name_1" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false"
                                            value="{{ $product_detail->product_option_name_1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="product_option_value_1" class="control-label mb-1">Option Value
                                            1</label>
                                        <input name="product_option_value_1" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false"
                                            value="{{ $product_detail->product_option_value_1 }}" required>
                                        @error('product_option_value_1')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($product_detail->product_option_name_2 != null)
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="product_option_name_2" class="control-label mb-1">Option Name 2</label>
                                        <input name="product_option_name_2" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false"
                                            value="{{ $product_detail->product_option_name_2 }}" readonly>
                                        @error('product_option_name_2')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="product_option_value_2" class="control-label mb-1">Option Value
                                            2</label>
                                        <input name="product_option_value_2" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false"
                                            value="{{ $product_detail->product_option_value_2 }}" required>
                                        @error('product_option_value_2')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($product_detail->product_option_name_3 != null)
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="product_option_name_3" class="control-label mb-1">Option Name 3</label>
                                        <input name="product_option_name_3" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false"
                                            value="{{ $product_detail->product_option_name_3 }}" readonly>
                                        @error('product_option_name_3')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="product_option_value_3" class="control-label mb-1">Option Value
                                            3</label>
                                        <input name="product_option_value_3" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false"
                                            value="{{ $product_detail->product_option_value_3 }}" required>
                                        @error('product_option_value_3')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label for="SKU" class="control-label mb-1">SKU</label>
                                    <input name="SKU" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" value={{ $product_detail->SKU }} required>
                                    @error('SKU')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="quantity" class="control-label mb-1">Quantity</label>
                                    <input name="quantity" type="number" min="0" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $product_detail->quantity }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="price" class="control-label mb-1">Price ($)</label>
                                    <input name="price" type="number" min="0" step="0.01" class="form-control"
                                        aria-required="true" aria-invalid="false" value="{{ $product_detail->price }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="discount_percent" class="control-label mb-1">Discount Percent (%)</label>
                                    <input name="discount_percent" type="number" min="0" max="100" class="form-control"
                                        aria-required="true" aria-invalid="false"
                                        value="{{ $product_detail->discount_percent }}" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="warranty_period" class="control-label mb-1">Warranty Period</label>
                                    <input name="warranty_period" type="number" min="1" max="60" class="form-control"
                                        aria-required="true" aria-invalid="false"
                                        value="{{ $product_detail->warranty_period }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="short_desc" class="control-label mb-1">Short Description</label>
                            <textarea name="short_desc" class="form-control" aria-required="true" aria-invalid="false" rows="4">{{ $product_detail->short_desc }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DATA TABLE-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <a href="{{ route('admin.product_detail', [$product_detail->product_id]) }}">
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
