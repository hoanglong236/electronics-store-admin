<div class="col-md-3">
    <div class="card card-hover">
        <div class="card-header card-header-flex--space-center">
            <div class="card-title--medium">ID:&nbsp; {{ $product->id }}</div>
            <a href="{{ route('catalog.product.detail', [$product->id]) }}">
                <button type="submit" class="btn btn-info btn-sm icon-button" data-toggle="tooltip"
                    data-placement="top" data-html="true" title="<span class='text--normal'>Detail</span>">
                    <i class="fa fa-info-circle"></i>
                </button>
            </a>
        </div>
        <img class="card-img-top card-image--medium" src="{{ asset('storage/' . $product->main_image_path) }}"
            alt="Product image">
        <div class="card-body">
            <div class="card-text">
                <div class="text-truncate--two-line">{{ $product->name }}</div>
                <div class="text-truncate">
                    Price:&nbsp;
                    @if ($product->discount_percent === 0)
                        {{ '$' . $product->price }}
                    @else
                        <span class="discount-price">
                            {{ '$' . $product->price * ((100 - $product->discount_percent) / 100) }}
                        </span>
                        <span class="original-price ml-1">{{ $product->price . '$' }}</span>
                    @endif
                </div>
                <div class="text-truncate">Quantity:&nbsp; {{ $product->quantity }}</div>
            </div>
        </div>
        <div class="card-footer">
            <div class="card-action-wrapper">
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
