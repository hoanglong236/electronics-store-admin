<div class="card">
    <div class="card-header">
        <span class="form-title">Update category</span>
    </div>
    <form action="{{ route('catalog.category.update-handler', $category->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body card-block">
            <div class="form-group">
                <label for="parentCategoryId" class="form-control-label">Parent category</label>
                <select id="parentCategoryId" name="parentId" class="form-control">
                    <option value="{{ Constants::NONE_VALUE }}">None</option>
                    @foreach ($categoryIdNameMap as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}" @selected(intval($category->parent_id) === $categoryId)>
                            {{ $categoryName }}
                        </option>
                    @endforeach
                </select>
                @error('parentId')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categoryName" class="form-control-label">Category name</label>
                <input id="categoryName" type="text" name="name" value="{{ $category->name }}"
                    class="form-control" required>
                @error('name')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categorySlug" class="form-control-label">Category slug</label>
                <input id="categorySlug" type="text" name="slug" value="{{ $category->slug }}"
                    class="form-control" required>
                @error('slug')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categoryIcon" class="form-control-label">New category icon?</label>
                <input id="categoryIcon" type="file" name="icon" class="form-control-file">
                @error('icon')
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
