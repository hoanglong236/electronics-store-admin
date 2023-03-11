<div class="card">
    <div class="card-header">
        <strong>Create Brand</strong>
    </div>
    <form action="{{ route('catalog.brand.create.handler') }}" method="post" enctype="multipart/form-data"
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
                <label for="brandLogo" class="form-control-label">Brand logo</label>
                <input id="brandLogo" type="file" name="logo" class="form-control-file" required>
                @error('logo')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Submit
            </button>
            <button type="reset" class="btn btn-danger btn-sm">
                <i class="fa fa-ban"></i> Reset
            </button>
        </div>
    </form>
</div>
