<div class="table-data7-wrapper mb-4">
    <table class="table table-data7 table-data7--custom">
        <thead>
            <tr>
                <th>#</th>
                <th colspan="2">Product Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>ID</td>
                <td>{{ $customProduct->id }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Category</td>
                <td>{{ $customProduct->category_name }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Brand</td>
                <td>{{ $customProduct->brand_name }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Name</td>
                <td>{{ $customProduct->name }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Slug</td>
                <td>{{ $customProduct->slug }}</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Price</td>
                <td>{{ '$' . number_format($customProduct->price, 2) }}</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Discount</td>
                <td>{{ $customProduct->discount_percent . '%' }}</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Quantity</td>
                <td>{{ $customProduct->quantity }}</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Warranty Period</td>
                <td>{{ $customProduct->warranty_period }}</td>
            </tr>
            <tr>
                <td>10</td>
                <td>Description</td>
                <td>{{ $customProduct->description }}</td>
            </tr>
        </tbody>
    </table>
</div>
