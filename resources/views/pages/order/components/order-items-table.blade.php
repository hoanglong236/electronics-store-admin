@php
    $totalDue = 0;
@endphp
<div class="table-responsive">
    <table class="table table-borderless table-data6 table-radius">
        <thead>
            <tr>
                <th>#</th>
                <th colspan="2">Product</th>
                <th>Qty</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $index => $orderItem)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <img class="product-image--small"
                            src="{{ asset('/storage' . '/' . $orderItem['productImagePath']) }}"
                            alt="{{ 'Product image' }}">
                    </td>
                    <td>
                        <span>{{ 'ID: ' . $orderItem['productId'] }}</span><br>
                        <span>{{ $orderItem['productName'] }}</span>
                    </td>
                    <td class="text-left">x {{ $orderItem['quantity'] }}</td>
                    <td>${{ number_format($orderItem['totalPrice'], 2) }}</td>
                </tr>
                @php
                    $totalDue += $orderItem['totalPrice'];
                @endphp
            @endforeach
            <tr class="table-total">
                <td></td>
                <td colspan="3">Total Due</td>
                <td>${{ number_format($totalDue, 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
