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
                @include('shared.components.buttons.edit-button', [
                    'editUrl' => route('catalog.brand.update', [$brand->id]),
                ])
            </div>
            <div class="card-action-item">
                @include('shared.components.buttons.delete-button', [
                    'deleteUrl' => route('catalog.brand.delete', [$brand->id]),
                ])
            </div>
        </div>
    </div>
</div>
