@extends('admin.layout')

@section('container')
    <h1>Coupon</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Coupon</div>
                <div class="card-body">
                    <form action="{{ route('admin.coupon.update_coupon_handle') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label mb-1">Coupon ID</label>
                            <input name="id" type="text" value="{{ $coupon->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="coupon_title" class="control-label mb-1">Coupon Title</label>
                            <input name="coupon_title" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $coupon->coupon_title }}" required>
                            @error('coupon_title')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="coupon_code" class="control-label mb-1">Coupon Code</label>
                                    <input name="coupon_code" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $coupon->coupon_code }}" required>
                                    @error('coupon_code')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="" class="control-label mb-1">Coupon Type</label>
                                    <div class="form-check form-control" style="border-style: none">
                                        <input id="is_percent_radio" class="form-check-input" type="radio"
                                            name="coupon_type" value="Percent" <?php if ($coupon->coupon_type == 'Percent') {echo 'checked';} ?>>
                                        <label class="form-check-label" for="coupon_type">
                                            Percent (%)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="" class="control-label mb-1"><br></label>
                                    <div class="form-check form-control" style="border-style: none">
                                        <input id="is_not_percent_radio" class="form-check-input" type="radio"
                                            name="coupon_type" value="Dollar" <?php if ($coupon->coupon_type == 'Dollar') {echo 'checked';} ?>>
                                        <label class="form-check-label" for="coupon_type">
                                            Dollar ($)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="coupon_percent_value" class="control-label mb-1">Percent Value (%)</label>
                                    <input id="percent_value_field" name="coupon_percent_value" type="number" min="0"
                                        max="100" class="form-control" aria-required="true" aria-invalid="false"
                                        <?php if ($coupon->coupon_type == 'Percent') {
                                            echo "value=\"" . $coupon->coupon_percent_value . "\"";
                                        } else {
                                            echo 'disabled';
                                        } ?> required>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="coupon_dollar_value" class="control-label mb-1">Dollar Value ($)</label>
                                    <input id="dollar_value_field" name="coupon_dollar_value" type="number" min="0"
                                        step="0.01" class="form-control" aria-required="true" aria-invalid="false"
                                        <?php if ($coupon->coupon_type == 'Dollar') {
                                            echo "value=\"" . $coupon->coupon_dollar_value . "\"";
                                        } else {
                                            echo 'disabled';
                                        } ?> required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="coupon_start_date" class="control-label mb-1">Start Date</label>
                                    <input name="coupon_start_date" type="date" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $coupon->coupon_start_date }}" required>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="coupon_finish_date" class="control-label mb-1">Finish Date</label>
                                    <input name="coupon_finish_date" type="date" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $coupon->coupon_finish_date }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="coupon_quantity" class="control-label mb-1">Quantity</label>
                                    <input name="coupon_quantity" type="number" min="0" class="form-control"
                                        aria-required="true" aria-invalid="false" value="{{ $coupon->coupon_quantity }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="coupon_status" class="control-label mb-1">Status</label>
                                    <select name="coupon_status" class="form-control">
                                        <option value="Stocking" <?php if ($coupon->coupon_status == 'Stocking') echo 'selected'; ?>>
                                            Stocking
                                        </option>
                                        <option value="Out of stock" <?php if ($coupon->coupon_status == 'Out of stock') echo 'selected'; ?>>
                                            Out of stock
                                        </option>
                                        <option value="Expired" <?php if ($coupon->coupon_status == 'Expired') echo 'selected'; ?>>
                                            Expired
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var is_percent__radio = document.getElementById('is_percent_radio');
        var is_not_percent_radio = document.getElementById('is_not_percent_radio');
        var percent_value_field = document.getElementById('percent_value_field');
        var dollar_value_field = document.getElementById('dollar_value_field');

        is_percent_radio.addEventListener('click', function() {
            percent_value_field.removeAttribute('disabled');
            dollar_value_field.setAttribute('disabled', "false");
            dollar_value_field.value = null;
        })

        is_not_percent_radio.addEventListener('click', function() {
            dollar_value_field.removeAttribute('disabled');
            percent_value_field.setAttribute('disabled', "false");
            percent_value_field.value = null;
        })
    </script>
    <!-- END DATA TABLE-->
    <a href="{{ route('admin.coupon') }}">
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
