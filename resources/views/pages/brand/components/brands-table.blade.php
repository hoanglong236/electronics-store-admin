<div class="table-responsive m-b-40">
    <table class="table table-borderless table-data4 table-radius">
        <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>
                        <img class="brand-logo--small" src="{{ asset('/storage' . '/' . $brand->logo_path) }}"
                            alt="{{ $brand->name . ' icon' }}">
                    </td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->slug }}</td>
                    <td>
                        <div class="card-action-wrapper--right">
                            <div class="card-action-item">
                                @include('shared.components.buttons.edit-icon-button', [
                                    'editUrl' => route('catalog.brand.update', [$brand->id]),
                                ])
                            </div>
                            <div class="card-action-item">
                                @include('shared.components.buttons.delete-icon-button', [
                                    'deleteUrl' => route('catalog.brand.delete', [$brand->id]),
                                ])
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($brands) === 0)
        <div class="mt-3">No brand found.</div>
    @endif
</div>
