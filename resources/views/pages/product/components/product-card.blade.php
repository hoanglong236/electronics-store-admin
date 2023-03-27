<div class="card card-hover">
    <div class="card-header card-header-flex--space-center">
        <div class="card-title--medium">ID:&nbsp; {{ $product->id }}</div>
        @include('shared.components.buttons.detail-icon-button', [
            'detailUrl' => route('catalog.product.details', [$product->id]),
        ])
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
                @include('shared.components.buttons.edit-button', [
                    'editUrl' => route('catalog.product.update', [$product->id]),
                ])
            </div>
            <div class="card-action-item">
                @include('shared.components.buttons.delete-button', [
                    'deleteUrl' => route('catalog.product.delete', [$product->id]),
                ])
            </div>
        </div>
    </div>
</div>
