@php
    $index = 1;
@endphp
<div class="table-data7-wrapper">
    <table class="table table-data7">
        <thead>
            <tr>
                <th>#</th>
                <th colspan="2">Customer Info</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $index++ }}</td>
                <td>ID</td>
                <td>{{ $customerInfo['id'] }}</td>
            </tr>
            <tr>
                <td>{{ $index++ }}</td>
                <td>Name</td>
                <td>{{ $customerInfo['name'] }}</td>
            </tr>
            <tr>
                <td>{{ $index++ }}</td>
                <td>Phone</td>
                <td>{{ $customerInfo['phone'] }}</td>
            </tr>
            <tr>
                <td>{{ $index++ }}</td>
                <td>Email</td>
                <td>{{ $customerInfo['email'] }}</td>
            </tr>
            <tr>
                <td>{{ $index++ }}</td>
                <td>Delivery Address</td>
                <td>{{ $customerInfo['deliveryAddress'] }}</td>
            </tr>
        </tbody>
    </table>
</div>
