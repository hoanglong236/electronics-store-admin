<div class="table-responsive table--no-card m-b-30">
    <table class="table table-borderless table-striped table-earning">
        <thead>
            <tr>
                <th scope="col" colspan="2" class="custom-table-header">Product detail</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="horizontal-table-title--small">ID</td>
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <td class="horizontal-table-title--small">Category</td>
                <td>{{ $categoryNameMap[$product->category_id] }}</td>
            </tr>
            <tr>
                <td class="horizontal-table-title--small">Brand</td>
                <td>{{ $brandNameMap[$product->brand_id] }}</td>
            </tr>
            <tr>
                <td class="horizontal-table-title--small">Name</td>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <td class="horizontal-table-title--small">Price ($)</td>
                <td>{{ $product->price }}</td>
            </tr>
            <tr>
                <td class="horizontal-table-title--small">Discount (%)</td>
                <td>{{ $product->discount_percent }}</td>
            </tr>
            <tr>
                <td class="horizontal-table-title--small">Quantity</td>
                <td>{{ $product->quantity }}</td>
            </tr>
            <tr>
                <td class="horizontal-table-title--small">Warranty Period</td>
                <td>{{ $product->warranty_period }}</td>
            </tr>
            <tr>
                <td class="horizontal-table-title--small">Description</td>
                <td>{{ $product->description }}</td>
            </tr>
        </tbody>
    </table>
</div>
