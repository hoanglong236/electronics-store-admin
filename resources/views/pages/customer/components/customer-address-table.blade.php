<table class="table table-borderless table-data5">
    <thead>
        <tr>
            <th>Province</th>
            <th>District</th>
            <th>Ward</th>
            <th>Specific address</th>
            <th>Address type</th>
            <th>Is default</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customerAddresses as $customerAddress)
            @include('pages.customer.components.customer-address-row')
        @endforeach
    </tbody>
</table>
