<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <strong class="card-title mb-3">ID:&nbsp; {{ $product->id }}</strong>
        </div>
        <img class="card-img-top card-img-custom" src="{{ asset('storage/' . $product->main_image_path) }}"
            alt="Product image">
        <div class="card-body">
            <div class="card-text">
                <div class="text-truncate--two-line">Name:&nbsp; <strong>{{ $product->name }}</strong></div>
                <div class="text-truncate">Category:&nbsp; {{ $categoryNameMap[$product->category_id] }}</div>
                <div class="text-truncate">
                    Price:&nbsp;
                    @if ($product->discount_percent === 0)
                        {{ $product->price . '$' }}
                    @else
                        <span class="discount-price">
                            {{ $product->price * ((100 - $product->discount_percent) / 100) . '$' }}
                        </span>
                        <span class="original-price">{{ $product->price . '$' }}</span>
                    @endif
                </div>
                <div class="text-truncate">Quantity:&nbsp; {{ $product->quantity }}</div>
            </div>
        </div>
        <div class="card-footer">
            <div class="card-action-wrapper">
                <div class="card-action-item">
                    <a href="{{ route('catalog.product.detail', [$product->id]) }}">
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fa fa-info-circle"></i> Detail
                        </button>
                    </a>
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
