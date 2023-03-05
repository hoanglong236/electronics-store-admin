<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <strong class="card-title mb-3">{{ $brand->name }}</strong>
        </div>
        <img class="card-img-top card-img-custom" src="{{ asset('/storage' . '/' . $brand->logo_path) }}"
            alt="{{ $brand->name . ' logo' }}">
        <div class="card-body">
            <div class="card-text">
                <div>ID: {{ $brand->id }}</div>
                <div class="text-truncate">Name: {{ $brand->name }}</div>
                <div class="text-truncate">Product count: {{ $brand->updated_at }}</div>
            </div>
        </div>
        <div class="card-footer">
            <div class="card-action-wrapper">
                <div class="card-action-item">
                    <a href="{{ route('catalog.brand.update', [$brand->id]) }}">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="zmdi zmdi-edit"></i> Edit
                        </button>
                    </a>
                </div>
                <div class="card-action-item">
                    <form method="post" action="{{ route('catalog.brand.delete', [$brand->id]) }}"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
