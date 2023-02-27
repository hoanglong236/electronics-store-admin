@extends('admin.layout')

@section('container')
    <h1>Order Detail</h1><br>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Order Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id" class="control-label mb-1">Order ID</label>
                        <input name="id" type="text" value="{{ $order->id }}" class="form-control" readonly>
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="customer_name" class="control-label mb-1">Customer Name</label>
                                <input name="customer_name" type="text" value="{{ $customer->firstname . " " . $customer->lastname }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="customer_id" class="control-label mb-1">Customer ID</label>
                                <input name="customer_id" type="text" value="{{ $order->customer_id }}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="delivery_address" class="control-label mb-1">Delivery Address</label>
                        <input name="delivery_address" type="text" value="{{ $order->delivery_address }}" class="form-control" readonly>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="total" class="control-label mb-1">Total</label>
                                <input name="total" type="text" value="{{ $order->total }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="payment_method" class="control-label mb-1">Payment Method</label>
                                <input name="payment_method" type="text" value="{{ $order->payment_method }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="payment_status" class="control-label mb-1">Payment Status</label>
                                <input name="payment_status" type="text" value="{{ $order->payment_status }}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="status" class="control-label mb-1">Order Status</label>
                                <input name="status" type="text" value="{{ $order->status }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="created_at" class="control-label mb-1">Created At</label>
                                <input name="created_at" type="text" value="{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y  H:i:s') }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="updated_at" class="control-label mb-1">Updated At</label>
                                <input name="updated_at" type="text" value="{{ \Carbon\Carbon::parse($order->updated_at)->format('d-m-Y  H:i:s') }}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1>Order Detail Items</h1><br>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sub_total = 0;
                        @endphp
                        @foreach ($result['order_detail_ids'] as $order_detail_id)
                            <tr>
                                <td style="text-align: left; vertical-align: middle;">
                                    <div style="float: left;">
                                        <img style="object-fit: cover; width: 100px; height: 120px;"
                                            src="{{ asset('/storage/product_image/' . $result[$order_detail_id]['image']) }}"
                                            alt="img"></a>
                                    </div>
                                    <div style="padding-left: 110px;">
                                        <div class="aa-cart-title">{{ $result[$order_detail_id]['name'] }}<br></div>
                                        <div>{{ $result[$order_detail_id]['option_name'] }}</div>
                                    </div>
                                    <br>
                                </td>
                                <td>{{ $result[$order_detail_id]['quantity'] }}</td>
                                <td>{{ $result[$order_detail_id]['total_price'] }}</td>
                            </tr>
                            @php
                                $sub_total += $result[$order_detail_id]['total_price'];
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
    <!-- END DATA TABLE-->
    {{-- js for alert (sweet alert 2) --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var has_alert = '{{ Session::has('alert') }}';
        if (has_alert) {
            var alert_message = '{{ Session::get('alert') }}';
            if (alert_message.indexOf("Error") == -1) {
                Swal.fire(
                    'Successfully!',
                    alert_message,
                    'success'
                )
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: $alert_message,
                })
            }
        }
    </script>
    <script src="{{ asset('admin_assets/js/orderStatus.js') }}"></script>
    <a href="{{ route('admin.order') }}">
        <button type="button" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
            </svg>
            &nbsp;Back
        </button>
    </a>
@endsection