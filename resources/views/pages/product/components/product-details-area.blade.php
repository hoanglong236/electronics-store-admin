@php
    $imagePaths = [$productInfo['mainImagePath']];
    foreach ($productImages as $productImage) {
        $imagePaths[] = $productImage['path'];
    }
@endphp

<div class="product-details-area">
    <div class="row">
        <div class="col-sm-3">
            @include('pages.product.components.product-image-sliders', [
                'imagePaths' => $imagePaths,
            ])
        </div>
        <div class="col-sm-9">
            <div class="product-info__name">{{ $productInfo['name'] }}</div>
            <div class="product-info__slug">Slug: {{ $productInfo['slug'] }}</div>

            <div class="product-info__price mt-4">
                @if ($productInfo['discountPercent'] === 0)
                    <span class="price">${{ $productInfo['price'] }}</span>
                @else
                    <span class="original-price mr-2">${{ number_format($productInfo['price']) }}</span>
                    <span class="price mr-2">
                        ${{ number_format($productInfo['price'] * (1 - $productInfo['discountPercent'] / 100)) }}
                    </span>
                    <span class="discount-percent">-{{ $productInfo['discountPercent'] }}%</span>
                @endif
            </div>

            <div class="mt-3">
                <span class="mr-3">Category: {{ $productInfo['categoryName'] }}</span>
                <span class="mr-3">-</span>
                <span>Brand: {{ $productInfo['brandName'] }}</span>
            </div>
            <div>Qty: {{ $productInfo['quantity'] }}</div>
            <div>Warranty: {{ $productInfo['warrantyPeriod'] }} month(s)</div>
            <div class="mt-3">
                <span class="mr-3">Created at: {{ $productInfo['createdAt'] }}</span>
                <span>Updated at: {{ $productInfo['updatedAt'] }}</span>
            </div>
        </div>
    </div>

    <div>
        Description: {{ $productInfo['description'] }}
    </div>
</div>
