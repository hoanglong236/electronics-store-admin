<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <strong class="card-title mb-3">Product profile</strong>
        </div>
        <img class="card-img-top card-img-custom" src="{{ asset('/storage' . '/' . $product->main_image_path) }}"
            alt="Product image">
        <div class="card-body">
            <div class="card-text">
                <div>ID: {{ $product->id }}</div>
                <div class="text-truncate">Category: {{ $categoryNameMap[$product->category_id] }}</div>
                <div class="text-truncate">Brand: {{ $brandNameMap[$product->brand_id] }}</div>
                <div class="text-truncate--two-line">Name: {{ $product->name }}</div>
            </div>
        </div>
        <div class="card-footer">
            <div class="card-action-wrapper">
                <div class="card-action-item">
                    {{-- <a href="{{ route('catalog.product.detail', [$product->id]) }}"> --}}
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fa fa-info-circle"></i> Detail
                    </button>
                    {{-- </a> --}}
                </div>
                <div class="card-action-item">
                    <a href="{{ route('catalog.product.update', [$product->id]) }}">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="zmdi zmdi-edit"></i> Edit
                        </button>
                    </a>
                </div>
                <div class="card-action-item">
                    <form method="post" action="{{ route('catalog.product.delete', [$product->id]) }}"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
