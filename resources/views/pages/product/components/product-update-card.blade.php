<div class="card">
    <div class="card-header">
        <strong>Update Product</strong>
    </div>
    <form action="{{ route('catalog.product.update-handler', $product->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body card-block">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="category" class="form-control-label">Category</label>
                        <select id="category" name="categoryId" class="form-control">
                            @foreach ($categoryMap as $categoryId => $category)
                                @if ($product->category_id === $categoryId)
                                    <option value="{{ $categoryId }}" selected>
                                        {{ $category->delete_flag ? $category->name . ' (deleted)' : $category->name }}
                                    </option>
                                @elseif (!$category->delete_flag)
                                    <option value="{{ $categoryId }}">{{ $category->name }}</option>
                                @endif
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
                            @foreach ($brandMap as $brandId => $brand)
                                @if ($product->brand_id === $brandId)
                                    <option value="{{ $brandId }}" selected>
                                        {{ $brand->delete_flag ? $brand->name . ' (deleted)' : $brand->name }}
                                    </option>
                                @elseif (!$brand->delete_flag)
                                    <option value="{{ $brandId }}">{{ $brand->name }}</option>
                                @endif
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
                <input id="productName" type="text" name="name" value="{{ $product->name }}" class="form-control"
                    required>
                @error('name')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="productSlug" class="form-control-label">Slug</label>
                <input id="productSlug" type="text" name="slug" value="{{ $product->slug }}" class="form-control"
                    required>
                @error('slug')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="productPrice" class="form-control-label">Price ($)</label>
                        <input id="productPrice" type="number" min="0" name="price"
                            value="{{ $product->price }}" class="form-control" required>
                        @error('price')
                            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="productDiscountPercent" class="form-control-label">Discount (%)</label>
                        <input id="productDiscountPercent" type="number" min="0" max="100"
                            name="discountPercent" value="{{ $product->discount_percent }}" class="form-control"
                            required>
                        @error('discountPercent')
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
                            value="{{ $product->quantity }}" class="form-control" required>
                        @error('quantity')
                            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="productWarrantyPeriod" class="form-control-label">Warranty Period</label>
                        <input id="productWarrantyPeriod" type="number" min="0" name="warrantyPeriod"
                            value="{{ $product->warranty_period }}" class="form-control" required>
                        @error('warrantyPeriod')
                            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="productDescription" class="form-control-label">Description</label>
                <input id="productDescription" type="text" name="description"
                    value="{{ $product->description }}" class="form-control" required>
                @error('description')
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
            @include('shared.components.buttons.submit-button')
            @include('shared.components.buttons.reset-button')
        </div>
    </form>
</div>
