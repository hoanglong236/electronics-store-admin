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
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Category</td>
                <td>{{ $categoryIdNameMap[$product->category_id] }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Brand</td>
                <td>{{ $brandIdNameMap[$product->brand_id] }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Name</td>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Slug</td>
                <td>{{ $product->slug }}</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Price</td>
                <td>{{ '$' . number_format($product->price, 2) }}</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Discount (%)</td>
                <td>{{ $product->discount_percent }}</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Quantity</td>
                <td>{{ $product->quantity }}</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Warranty Period</td>
                <td>{{ $product->warranty_period }}</td>
            </tr>
            <tr>
                <td>10</td>
                <td>Description</td>
                <td>{{ $product->description }}</td>
            </tr>
        </tbody>
    </table>
</div>
