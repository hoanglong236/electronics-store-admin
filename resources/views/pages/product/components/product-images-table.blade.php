<div class="table-responsive table--no-card m-b-30">
    <table class="table table-borderless table-data4 table-radius">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                $index = 1;
            @endphp

            <tr>
                <td>{{ $index++ }}</td>
                <td>
                    <img class="product-image--small" src="{{ asset('/storage' . '/' . $mainImagePath) }}"
                        alt="Main image">
                </td>
                <td></td>
            </tr>

            @foreach ($productImages as $productImage)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>
                        <img class="product-image--small" src="{{ asset('/storage' . '/' . $productImage['path']) }}"
                            alt="image">
                    </td>
                    <td class="text-right">
                        @include('shared.components.buttons.delete-icon-button', [
                            'deleteUrl' => route('catalog.product.details.images.delete', [
                                'productId' => $productId,
                                'productImageId' => $productImage['id'],
                            ]),
                        ])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
