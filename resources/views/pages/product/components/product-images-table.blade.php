<div class="table-responsive table--no-card m-b-30">
    <table class="table table-borderless table-striped table-earning table-earning--custom">
        <thead>
            <tr>
                <th>Order</th>
                <th>Image</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productImages as $key => $productImage)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <img class="product-image--small" src="{{ asset('/storage' . '/' . $productImage->image_path) }}"
                            alt="{{ 'Image ' . $key }}">
                    </td>
                    <td class="text-right">
                        <form method="post"
                            action="{{ route('catalog.product.details.images.delete', [
                                'productId' => $product->id,
                                'productImageId' => $productImage->id,
                            ]) }}"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
