<div class="table-responsive m-b-40">
    <table class="table table-borderless table-data6 table-radius">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customOrderItems as $customOrderItem)
                <tr>
                    <td>
                        <img class="product-image--small" src="{{ asset('/storage' . '/' . $customOrderItem->product_image_path) }}"
                            alt="{{ 'Product image' }}">
                    </td>
                    <td>
                        <span>{{ 'ID: ' . $customOrderItem->product_id }}</span><br>
                        <span>{{ $customOrderItem->product_name }}</span>
                    </td>
                    <td>{{ $customOrderItem->quantity }}</td>
                    <td>{{ '$' . number_format($customOrderItem->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
