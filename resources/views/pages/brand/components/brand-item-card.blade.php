<div class="card">
    <div class="card-header">
        <span class="card-title--small">ID:&nbsp; {{ $brand->id }}</span>
    </div>
    <img class="card-img-top card-image--small" src="{{ asset('storage/' . $brand->logo_path) }}"
        alt="{{ $brand->name . ' logo' }}">
    <div class="card-body">
        <div class="card-text">
            <div class="text-truncate mb-1 text--bold">{{ $brand->name }}</div>
            <div class="text-truncate">Slug:&nbsp; {{ $brand->slug }}</div>
        </div>
    </div>
    <div class="card-footer">
        <div class="card-action-wrapper">
            <div class="card-action-item">
                <a href="{{ route('catalog.brand.update', [$brand->id]) }}">
                    <button type="submit" class="btn btn-primary btn-sm text-small">
                        <i class="zmdi zmdi-edit"></i> Edit
                    </button>
                </a>
            </div>
            <div class="card-action-item">
                <form method="post" action="{{ route('catalog.brand.delete', [$brand->id]) }}"
                    onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm text-small">
                        <i class="fa fa-trash-o"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
