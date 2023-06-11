<div class="card">
    <div class="card-header">
        <strong>Create Product</strong>
    </div>
    <form action="{{ route('catalog.product.create-handler') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body card-block">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="category" class="form-control-label">Category</label>
                        <select id="category" name="categoryId" class="form-control">
                            @foreach ($categoryMap as $categoryId => $category)
                                <option value="{{ $categoryId }}" @selected(intval(old('categoryId')) === $categoryId)>
                                    {{ $category->name }}
                                </option>
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
                                <option value="{{ $brandId }}" @selected(intval(old('brandId')) === $brandId)>
                                    {{ $brand->name }}
                                </option>
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
                <input id="productName" type="text" name="name" value="{{ old('name') }}" class="form-control"
                    required>
                @error('name')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="productSlug" class="form-control-label">Slug</label>
                <input id="productSlug" type="text" name="slug" value="{{ old('slug') }}" class="form-control"
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
                            value="{{ old('price') }}" class="form-control" required>
                        @error('price')
                            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="productDiscountPercent" class="form-control-label">Discount (%)</label>
                        <input id="productDiscountPercent" type="number" min="0" max="100"
                            name="discountPercent" value="{{ old('discountPercent') }}" class="form-control" required>
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
                            value="{{ old('quantity') }}" class="form-control" required>
                        @error('quantity')
                            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="productWarrantyPeriod" class="form-control-label">Warranty Period</label>
                        <input id="productWarrantyPeriod" type="number" min="0" name="warrantyPeriod"
                            value="{{ old('warrantyPeriod') }}" class="form-control" required>
                        @error('warrantyPeriod')
                            <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="productDescription" class="form-control-label">Description</label>
                <input id="productDescription" type="text" name="description" value="{{ old('description') }}"
                    class="form-control" required>
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
            @include('shared.components.buttons.submit-button')
            @include('shared.components.buttons.reset-button')
        </div>
    </form>
</div>
