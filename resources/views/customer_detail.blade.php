@extends('admin.layout')

@section('container')
    <h1>Customer Details</h1><br>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            {{-- display customer infomation --}}
            <div class="card">
                <div class="card-header">Customer Information</div>
                <div class="card-body">
                    <div class="form-group" style="text-align: center;">
                        <img class="customer_image" src="{{ asset('/storage/product_image/1649245575.jpg') }}">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="id" class="control-label mb-1">Customer ID</label>
                        <input name="id" type="text" value="{{ $customer->id }}" class="form-control" readonly>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="firstname" class="control-label mb-1">First Name</label>
                                <input name="firstname" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value={{ $customer->firstname }} readonly>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="lastname" class="control-label mb-1">Last Name</label>
                                <input name="lastname" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value={{ $customer->lastname }} readonly>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="gender" class="control-label mb-1">Gender</label>
                                <select name="gender" class="form-control" readonly>
                                    <option value="Male" @if ($customer->gender == 'Male') selected @endif>Male</option>
                                    <option value="Female" @if ($customer->gender == 'Female') selected @endif>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="firstname" class="control-label mb-1">Phone</label>
                                <input name="firstname" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value={{ $customer->phone }} readonly>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="firstname" class="control-label mb-1">Email</label>
                                <input name="firstname" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value={{ $customer->email }} readonly>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="firstname" class="control-label mb-1">Status</label>
                                <input name="firstname" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value={{ $customer->status }} readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><hr>
            {{-- display customer addresses --}}
            <h1>Customer Addresses</h1><br>
            @php
                $count = 0;
            @endphp
            @if ($customer_addresses->isNotEmpty())
                @foreach ($customer_addresses as $customer_address)
                    <div class="card">
                        @php
                            $count++;
                        @endphp
                        <div class="card-header">Customer Address {{ $count }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="id" class="control-label mb-1">Address ID</label>
                                        <input name="id" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value="{{ $customer_address->id }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="customer_id" class="control-label mb-1">Customer ID</label>
                                        <input name="customer_id" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value="{{ $customer_address->customer_id }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ZIP_code" class="control-label mb-1">ZIP Code</label>
                                        <input name="ZIP_code" type="text" class="form-control" aria-required="true"
                                            aria-invalid="false" value="{{ $customer_address->ZIP_code }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="city_or_province" class="control-label mb-1">City (Province)</label>
                                        <input name="city_or_province" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ $customer_address->city_or_province }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="district" class="control-label mb-1">District</label>
                                        <input name="district" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ $customer_address->district }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ward_or_commune" class="control-label mb-1">Ward (Commune)</label>
                                        <input name="ward_or_commune" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ $customer_address->ward_or_commune }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="specific_address" class="control-label mb-1">Specific Address</label>
                                <input name="specific_address" type="text" class="form-control"
                                    aria-required="true" aria-invalid="false" value="{{ $customer_address->specific_address }}" readonly>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Address Type</label>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-check form-control" style="border-style: none">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ 'address_type' . $count }}" value="Home" 
                                                        @if ($customer_address->address_type == 'Home') checked @endif>
                                                    <label for="address_type">Home</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-check form-control" style="border-style: none">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ 'address_type' . $count }}" value="Office"
                                                        @if ($customer_address->address_type == 'Office') checked @endif>
                                                    <label for="address_type">Office</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Is Default Address</label>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-check form-control" style="border-style: none">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ 'default_address' . $count }}" value="Home" 
                                                        @if ($customer_address->default_address == 'Yes') checked @endif>
                                                    <label for="default_address">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-check form-control" style="border-style: none">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ 'default_address' . $count }}" value="Office"
                                                        @if ($customer_address->default_address == 'No') checked @endif>
                                                    <label for="default_address">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="created_at" class="control-label mb-1">Created At</label>
                                        <input name="created_at" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ \Carbon\Carbon::parse($customer_address->created_at)->format('d-m-Y  H:i:s') }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="updated_at" class="control-label mb-1">Updated At</label>
                                        <input name="updated_at" type="text" class="form-control"
                                            aria-required="true" aria-invalid="false" value="{{ \Carbon\Carbon::parse($customer_address->updated_at)->format('d-m-Y  H:i:s') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
            @endif
            {{-- <a href="">
                <button type="button" class="btn btn-success">Add Address</button>
            </a>
            <a href="">
                <button type="button" class="btn btn-success">Update Address</button>
            </a>
            <a href="">
                <button type="button" class="btn btn-success">Delete Address</button>
            </a> --}}
        </div>
        <!-- END DATA TABLE-->
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
    <a href="{{ route('admin.customer') }}">
        <button type="button" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z" />
            </svg>
            &nbsp;Back
        </button>
    </a>
@endsection
