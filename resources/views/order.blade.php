@extends('admin.layout')

@section('container')
    <h1>Order</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer ID</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle">{{ $order->id }}</td>
                                <td class="align-middle">{{ $order->customer_id }}</td>
                                <td class="align-middle">{{ $order->customer_phone }}</td>
                                <td class="align-middle">{{ $order->total }}</td>
                                <td class="align-middle">
                                    <div class="form-group">
                                        <label for="orderStatus" class="control-label mb-1"></label>
                                        <select name="orderStatus" class="form-control" onchange="updateOrderStatus(this, {{ $order->id }})">
                                            @if ($order->status == "Received")
                                                <option value="Received" selected="">Received</option>
                                                <option value="Processed">Processed</option>
                                                <option value="Cancelled">Cancelled</option>
                                            @endif
                                            @if ($order->status == "Processed")
                                                <option value="Processed" selected="">Processed</option>
                                                <option value="Packed">Packed</option>
                                                <option value="Cancelled">Cancelled</option>
                                            @endif
                                            @if ($order->status == "Packed")
                                                <option value="Packed" selected="">Packed</option>
                                                <option value="Delivery">Delivery</option>
                                                <option value="Cancelled">Cancelled</option>
                                            @endif
                                            @if ($order->status == "Delivery")
                                                <option value="Delivery" selected="">Delivery</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Cancelled</option>
                                            @endif
                                            @if ($order->status == "Completed")
                                                <option value="Completed" selected="">Completed</option>
                                            @endif
                                            @if ($order->status == "Cancelled")
                                                <option value="Cancelled" selected="">Cancelled</option>
                                            @endif
                                        </select>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="#" id="{{ $order->id }}" name="delete_order_btn"><button
                                            type="button" class="btn btn-danger btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </button></a>
                                    <a href="#"><button
                                            type="button" class="btn btn-success btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                <path
                                                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                            </svg>
                                        </button></a>
                                    <a href="{{ route('admin.order_detail', [$order->id]) }}"><button
                                            type="button" class="btn btn-secondary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                <path
                                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                            </svg>
                                        </button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
    <!-- END DATA TABLE-->
    {{-- js for alert (sweet alert 2)--}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var has_alert = '{{ Session::has('alert') }}';
        if (has_alert) {
            var alert_message = '{{ Session::get('alert') }}';
            if (alert_message.indexOf("Error") == -1){
                Swal.fire(
                    'Successfully!',
                    alert_message,
                    'success'
                )
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: $alert_message,
                })
            }  
        }
    </script>
    <script src="{{ asset('admin_assets/js/orderStatus.js') }}"></script>
    {{-- <a href="{{ route('admin.category.add_category') }}">
        <button type="button" class="btn btn-success">Add Category</button>
    </a> --}}
@endsection
