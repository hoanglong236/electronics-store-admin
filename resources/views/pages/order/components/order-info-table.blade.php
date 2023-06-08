@php
    $index = 1;
@endphp
<div class="table-data7-wrapper">
    <table class="table table-data7">
        <thead>
            <tr>
                <th>#</th>
                <th colspan="2">Order Info</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $index++ }}</td>
                <td>ID</td>
                <td>{{ $orderInfo['id'] }}</td>
            </tr>
            <tr>
                <td>{{ $index++ }}</td>
                <td>Status</td>
                <td>{{ $orderInfo['status'] }}</td>
            </tr>
            <tr>
                <td>{{ $index++ }}</td>
                <td>Payment method</td>
                <td>{{ $orderInfo['paymentMethod'] }}</td>
            </tr>
            <tr>
                <td>{{ $index++ }}</td>
                <td>Created At</td>
                <td>{{ $orderInfo['createdAt'] }}</td>
            </tr>
            <tr>
                <td>{{ $index++ }}</td>
                <td>Updated At</td>
                <td>{{ $orderInfo['updatedAt'] }}</td>
            </tr>
        </tbody>
    </table>
</div>
