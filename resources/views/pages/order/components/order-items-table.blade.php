<div class="table-responsive">
    <table class="table table-borderless table-data6 table-radius">
        <thead>
            <tr>
                <th>#</th>
                <th colspan="3">Product</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customOrderItems as $index => $customOrderItem)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <img class="product-image--small"
                            src="{{ asset('/storage' . '/' . $customOrderItem->product_image_path) }}"
                            alt="{{ 'Product image' }}">
                    </td>
                    <td>
                        <span>{{ 'ID: ' . $customOrderItem->product_id }}</span><br>
                        <span>{{ $customOrderItem->product_name }}</span>
                    </td>
                    <td class="text-left">x {{ $customOrderItem->quantity }}</td>
                    <td>{{ '$' . number_format($customOrderItem->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
