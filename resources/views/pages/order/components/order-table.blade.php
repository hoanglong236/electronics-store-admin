<div class="table-responsive m-b-40">
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
                                'order-cancelled' => $customOrder->status === Constants::ORDER_STATUS_CANCELLED,
                                'order-completed' => $customOrder->status === Constants::ORDER_STATUS_COMPLETED,
                            ])>{{ $orderStatusNameMap[$customOrder->status] }}</span>
                        @else
                            <form action="{{ route('manage.order.update-order-status', $customOrder->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control text--small" onchange="this.form.submit()">
                                    <option value="{{ $customOrder->status }}">
                                        {{ $orderStatusNameMap[$customOrder->status] }}
                                    </option>
                                    @foreach ($nextSelectableStatusMap[$customOrder->status] as $nextStatus)
                                        <option value="{{ $nextStatus }}">{{ $orderStatusNameMap[$nextStatus] }}</option>
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
                        <a href="{{ route('manage.order.details', $customOrder->id) }}">
                            <button type="submit" class="btn btn-info icon-btn">
                                <i class="fa fa-info-circle"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
