<div class="card">
    <div class="card-header">
        <span class="form-title">Update category</span>
    </div>
    <form action="{{ route('catalog.category.update.handler', $category->id) }}" method="post"
        enctype="multipart/form-data" class="form-horizontal">
        @csrf
        @method('PUT')
        <div class="card-body card-block">
            <div class="form-group">
                <label for="parentCategoryId" class="form-control-label">Parent category</label>
                <select id="parentCategoryId" name="parentId" class="form-control">
                    <option value="{{ Constants::NONE_VALUE }}">None</option>
                    @foreach ($categoryIdNameMap as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}" @selected(intval($category->parent_id) === $categoryId)>{{ $categoryName }}</option>
                    @endforeach
                </select>
                @error('parentId')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categoryName" class=" form-control-label">Category name</label>
                <input id="categoryName" type="text" name="name" value="{{ $category->name }}"
                    class="form-control" required>
                @error('name')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categorySlug" class=" form-control-label">Category slug</label>
                <input id="categorySlug" type="text" name="slug" value="{{ $category->slug }}"
                    class="form-control" required>
                @error('slug')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categoryLogo" class="form-control-label">New category logo?</label>
                <input id="categoryLogo" type="file" name="logo" class="form-control-file">
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
