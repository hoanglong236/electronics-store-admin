<div class="table-responsive m-b-40">
    <table class="table table-borderless table-data4 table-radius">
        <thead>
            <tr>
                <th>ID</th>
                <th>Icon</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Parent</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        <img class="category-icon--small" src="{{ asset('storage/' . $category->icon_path) }}"
                            alt="{{ $category->name . ' icon' }}">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ is_null($category->parent_id) ? '--' : $categoryIdNameMap[$category->parent_id] }}
                    </td>
                    <td>
                        <div class="card-action-wrapper--right">
                            <div class="card-action-item">
                                @include('shared.components.buttons.edit-icon-button', [
                                    'editUrl' => route('catalog.category.update', [$category->id]),
                                ])
                            </div>
                            <div class="card-action-item">
                                @include('shared.components.buttons.delete-icon-button', [
                                    'deleteUrl' => route('catalog.category.delete', [$category->id]),
                                ])
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($categories) === 0)
        <div class="mt-3">No category found.</div>
    @endif
</div>
