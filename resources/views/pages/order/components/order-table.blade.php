<table class="table table-borderless table-data6">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer Info</th>
            <th>Delivery Address</th>
            <th>Total</th>
            <th>Status</th>
            <th>Updated at</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customOrders as $customOrder)
            <tr>
                <td>{{ $customOrder->id }}</td>
                <td>
                    <div>{{ $customOrder->customer_name }}</div>
                    <div>{{ 'Phone: ' . $customOrder->customer_phone }}</div>
                </td>
                <td>{{ $customOrder->delivery_address }}</td>
                <td>{{ '$' . number_format($customOrder->total, 2) }}</td>
                <td>
                    @if (count($nextSelectableStatusMap[$customOrder->status]) === 0)
                        {{ $customOrder->status }}
                    @else
                        <form action="{{ route('manage.order.update-order-status', $customOrder->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control form-select--small" onchange="this.form.submit()">
                                <option value="{{ $customOrder->status }}">{{ $customOrder->status }}</option>
                                @foreach ($nextSelectableStatusMap[$customOrder->status] as $nextStatus)
                                    <option value="{{ $nextStatus }}">{{ $nextStatus }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                @if (intval(Session::get('orderId')) === $customOrder->id)
                                    <div class="alert alert-danger mt-1 alert--small" role="alert">{{ $message }}
                                    </div>
                                @endif
                            @enderror
                        </form>
                    @endif
                </td>
                <td>{{ $customOrder->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
