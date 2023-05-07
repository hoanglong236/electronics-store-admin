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
                <td>1</td>
                <td>ID</td>
                <td>{{ $orderInfo['id'] }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Status</td>
                <td>{{ $orderInfo['status'] }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Total amount</td>
                <td>{{ '$' . number_format($orderInfo['totalAmount'], 2) }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Payment method</td>
                <td>{{ $orderInfo['paymentMethod'] }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Created At</td>
                <td>{{ $orderInfo['createdAt'] }}</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Updated At</td>
                <td>{{ $orderInfo['updatedAt'] }}</td>
            </tr>
        </tbody>
    </table>
</div>
