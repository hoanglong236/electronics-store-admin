<div class="card">
    <div class="card-header card-header-flex">
        <span class="form-title">Create category</span>
    </div>
    <form action="{{ route('catalog.category.create-handler') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body card-block">
            <div class="form-group">
                <label for="parentCategoryId" class="form-control-label">Parent category</label>
                <select id="parentCategoryId" name="parentId" class="form-control">
                    <option value="{{ CommonConstants::NONE_VALUE }}">None</option>
                    @foreach ($categoryMap as $parentCategoryId => $parentCategory)
                        <option value="{{ $parentCategoryId }}" @selected(intval(old('parentId')) === $parentCategoryId)>
                            {{ $parentCategory->name }}
                        </option>
                    @endforeach
                </select>
                @error('parentId')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categoryName" class="form-control-label">Category name</label>
                <input id="categoryName" type="text" name="name" value="{{ old('name') }}" class="form-control"
                    required>
                @error('name')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categorySlug" class="form-control-label">Category slug</label>
                <input id="categorySlug" type="text" name="slug" value="{{ old('slug') }}" class="form-control"
                    required>
                @error('slug')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categoryIcon" class="form-control-label">Category icon</label>
                <input id="categoryIcon" type="file" name="icon" class="form-control-file" required>
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
