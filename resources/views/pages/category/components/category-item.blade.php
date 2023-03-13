<tr>
    <td>{{ $category->id }}</td>
    <td>
        @if (isset($category->icon_path))
            <img class="category-icon--small" src="{{ asset('/storage' . '/' . $category->icon_path) }}"
                alt="{{ $category->name . ' icon' }}">
        @else
            --
        @endif
    </td>
    <td>{{ $category->name }}</td>
    <td>{{ $category->slug }}</td>
    <td>{{ is_null($category->parent_id) ? '--' : $categoryIdNameMap[$category->parent_id] }}</td>
    <td>
        <div class="card-action-wrapper--right">
            <div class="card-action-item">
                <a href="{{ route('catalog.category.update', [$category->id]) }}">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="zmdi zmdi-edit"></i>
                    </button>
                </a>
            </div>
            <div class="card-action-item">
                <form method="post" action="{{ route('catalog.category.delete', [$category->id]) }}"
                    onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </form>
            </div>
        </div>
    </td>
</tr>
