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
                    <label for="emailKeyword" class="mr-3">Email:</label>
                    <input type="text" name="emailKeyword" id="emailKeyword" value="{{ $emailKeyword }}"
                        class="order-filter--form-control">
                </div>
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
                @include('shared.components.date-range-picker', [
                    'label' => 'Create date',
                    'fromDateInputName' => 'fromDate',
                    'fromDate' => $fromDate,
                    'toDateInputName' => 'toDate',
                    'toDate' => $toDate,
                ])
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
