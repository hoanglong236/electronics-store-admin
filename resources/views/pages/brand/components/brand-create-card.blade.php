<div class="card">
    <div class="card-header">
        <span class="card-title--medium">Create brand</span>
    </div>
    <form action="{{ route('catalog.brand.create-handler') }}" method="post" enctype="multipart/form-data"
        class="form-horizontal">
        @csrf
        <div class="card-body card-block">
            <div class="form-group">
                <label for="brandName" class="form-control-label">Brand name</label>
                <input id="brandName" type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                @error('name')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="brandSlug" class="form-control-label">Brand slug</label>
                <input id="brandSlug" type="text" name="slug" value="{{ old('slug') }}" class="form-control" required>
                @error('slug')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="brandLogo" class="form-control-label">Brand logo</label>
                <input id="brandLogo" type="file" name="logo" class="form-control-file" required>
                @error('logo')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            @include('shared.components.buttons.submit-button')
            @include('shared.components.buttons.reset-button')
        </div>
    </form>
</div>
