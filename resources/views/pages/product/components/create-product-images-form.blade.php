<div class="card">
    <div class="card-header">
        <strong>Add product image</strong>
    </div>
    <form action="{{ route('catalog.product.detail.images.create.handler', ['productId' => $product->id]) }}"
        method="post" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="card-body card-block">
            <div class="form-group">
                <label for="productImageSlider" class="form-control-label">Add slider images?</label>
                <input id="productImageSlider" name="images[]" type="file" class="form-control-file" multiple
                    required>
                @error('images')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
                @error('images.*')
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
