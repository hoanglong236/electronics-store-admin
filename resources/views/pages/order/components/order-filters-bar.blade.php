<form action="{{ $orderFilterUrl }}" method="GET">
    <div class="d-flex-center-space-between-wrap">
        <div>
            <div class="d-flex-wrap m-b-6">
                <div class="mr-5">
                    <label for="orderIdKeyword" class="mr-3">ID:</label>
                    <input type="text" name="orderIdKeyword" id="orderIdKeyword" value="{{ $orderIdKeyword }}"
                        class="order-filter--form-control order-filter-id">
                </div>
                <div>
                    <label for="phoneOrEmailKeyword" class="mr-3">Phone/Email:</label>
                    <input type="text" name="phoneOrEmailKeyword" id="phoneOrEmailKeyword"
                        value="{{ $phoneOrEmailKeyword }}" class="order-filter--form-control">
                </div>
            </div>
            <div class="m-b-6">
                <label for="deliveryAddressKeyword" class="mr-3">Delivery Address:</label>
                <input type="text" name="deliveryAddressKeyword" id="deliveryAddressKeyword"
                    value="{{ $deliveryAddressKeyword }}" class="order-filter--form-control">
            </div>
            <div class="d-flex-wrap m-b-6">
                <div class="mr-5">
                    <label for="statusFilter" class="mr-3">Status:</label>
                    <select name="statusFilter" id="statusFilter" class="order-filter--form-control" required>
                        <option value="All">All</option>
                        <option value="Received" @selected($statusFilter === 'Received')>Received</option>
                        <option value="Processing" @selected($statusFilter === 'Processing')>Processing</option>
                        <option value="Delivering" @selected($statusFilter === 'Delivering')>Delivering</option>
                        <option value="Completed" @selected($statusFilter === 'Completed')>Completed</option>
                        <option value="Cancelled" @selected($statusFilter === 'Cancelled')>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label for="paymentMethodFilter" class="mr-3">Payment Method:</label>
                    <select name="paymentMethodFilter" id="paymentMethodFilter" class="order-filter--form-control"
                        required>
                        <option value="All">All</option>
                        <option value="COD" @selected($paymentMethodFilter === 'COD')>COD</option>
                        <option value="Visa" @selected($paymentMethodFilter === 'Visa')>Visa</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="sortField" class="mr-3">Sort by:</label>
                <select name="sortField" id="sortField" class="order-filter--form-control" required>
                    <option value="createdAt" @selected($sortField === 'createdAt')>Created at</option>
                    <option value="updatedAt" @selected($sortField === 'updatedAt')>Updated at</option>
                </select>
            </div>
        </div>

        <div>
            <button type="submit" class="primary-submit-btn">SEARCH</button>
        </div>
    </div>
</form>

@if ($errors->any())
    <script>
        const message = '{{ implode(' ', $errors->all()) }}';
        alert(message);
    </script>
@endif
