<div class="table-responsive m-b-40">
    <table class="table table-borderless table-data6 table-radius">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Total</th>
                <th>Payment<br>method</th>
                <th>Status</th>
                <th>Create date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_email }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>
                        @if (count($nextSelectableStatusMap[$order->status]) === 0)
                            <span @class([
                                'order-cancelled' => $order->status === 'Cancelled',
                                'order-completed' => $order->status === 'Completed',
                            ])>{{ $order->status }}</span>
                        @else
                            <form action="{{ route('manage.order.update-order-status', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control text--small" onchange="this.form.submit()">
                                    <option value="{{ $order->status }}">
                                        {{ $order->status }}
                                    </option>
                                    @foreach ($nextSelectableStatusMap[$order->status] as $nextStatus)
                                        <option value="{{ $nextStatus }}">
                                            {{ $nextStatus }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    @if (intval(Session::get('orderId')) === $order->id)
                                        <div class="alert alert-danger mt-1 text--small" role="alert">{{ $message }}
                                        </div>
                                    @endif
                                @enderror
                            </form>
                        @endif
                    </td>
                    <td>{{ $order->create_date }}</td>
                    <td>
                        @include('shared.components.buttons.detail-icon-button', [
                            'detailUrl' => route('manage.order.details', $order->id),
                        ])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($orders) === 0)
        <div class="mt-3">No order found.</div>
    @endif
</div>
