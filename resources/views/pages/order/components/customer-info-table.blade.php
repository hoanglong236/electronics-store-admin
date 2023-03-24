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
                <td>1</td>
                <td>Customer Id</td>
                <td>{{ $customerInfo['id'] }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Name</td>
                <td>{{ $customerInfo['name'] }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Phone</td>
                <td>{{ $customerInfo['phone'] }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Email</td>
                <td>{{ $customerInfo['email'] }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Delivery Address</td>
                <td>
                    <span style="font-weight: 600;">(Office)</span>&nbsp;
                    {{ $customerInfo['deliveryAddress'] }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
