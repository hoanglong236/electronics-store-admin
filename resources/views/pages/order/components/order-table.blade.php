<table class="table table-borderless table-data6 table-radius">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Delivery Address</th>
            <th>Total</th>
            <th>Status</th>
            <th>Updated at</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customOrders as $customOrder)
            <tr>
                <td>{{ $customOrder->id }}</td>
                <td>
                    {{ $customOrder->customer_name }}<br>
                    {{ $customOrder->customer_email }}
                </td>
                <td>{{ $customOrder->delivery_address }}</td>
                <td>{{ '$' . number_format($customOrder->total, 2) }}</td>
                <td>
                    @if (count($nextSelectableStatusMap[$customOrder->status]) === 0)
                        <span @class([
                            'order-cancelled' => $customOrder->status === 'Cancelled',
                            'order-completed' => $customOrder->status === 'Completed',
                        ])>{{ $customOrder->status }}</span>
                    @else
                        <form action="{{ route('manage.order.update-order-status', $customOrder->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control text--small" onchange="this.form.submit()">
                                <option value="{{ $customOrder->status }}">{{ $customOrder->status }}</option>
                                @foreach ($nextSelectableStatusMap[$customOrder->status] as $nextStatus)
                                    <option value="{{ $nextStatus }}">{{ $nextStatus }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                @if (intval(Session::get('orderId')) === $customOrder->id)
                                    <div class="alert alert-danger mt-1 text--small" role="alert">{{ $message }}
                                    </div>
                                @endif
                            @enderror
                        </form>
                    @endif
                </td>
                <td>{{ $customOrder->updated_at }}</td>
                <td>
                    <a href="{{ route('manage.order.detail', $customOrder->id) }}">
                        <button type="submit" class="btn btn-info btn-sm icon-button">
                            <i class="fa fa-info-circle"></i>
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>