<div class="card">
    <div class="card-header">
        <strong>Add product image</strong>
    </div>
    <form action="{{ route('catalog.product.details.images.create.handler', ['productId' => $product->id]) }}"
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
            @include('shared.components.buttons.submit-button')
            @include('shared.components.buttons.reset-button')
        </div>
    </form>
</div>
