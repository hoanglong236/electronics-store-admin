<tr>
    <td>{{ $key + 1 }}</td>
    <td>
        <img class="product-image--small" src="{{ asset('/storage' . '/' . $productImage->image_path) }}"
            alt="{{ 'Image ' . $key }}">
    </td>
    <td class="text-right">
        <form method="post"
            action="{{ route('catalog.product.detail.images.delete', ['productId' => $product->id, 'productImageId' => $productImage->id]) }}"
            onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa fa-trash-o"></i>
            </button>
        </form>
    </td>
</tr>
