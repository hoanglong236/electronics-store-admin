@extends('admin.layout')

@section('container')
    <h1>Category</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Category</div>
                <div class="card-body">
                    <form action="{{ route('admin.category.update_category_handle') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label mb-1">Category ID</label>
                            <input name="id" type="text" value="{{ $category->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="category_name" class="control-label mb-1">Category Name</label>
                            <input name="category_name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $category->category_name }}" required>
                            @error('category_name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_slug" class="control-label mb-1">Category Slug</label>
                            <input name="category_slug" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $category->category_slug }}" required>
                            @error('category_slug')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_parent_id" class="control-label mb-1">Category Parent</label>
                            <select name="category_parent_id" class="form-select" aria-required="true" aria-invalid="false">
                                <option value="">Select a category</option>
                                @foreach ($category_data as $category_parent)
                                    <option value="{{ $category_parent->id }}" @if ($category->category_parent_id != null && $category_parent->id == $category->category_parent_id) selected @endif>
                                        {{ $category_parent->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="" class="control-label mb-1">Update Product Image?</label>
                                    <div class="form-check form-control" style="border-style: none">
                                        <input id="update_image_radio" class="form-check-input" type="radio"
                                            name="is_category_image_update_radio" value="yes">
                                        <label class="form-check-label" for="is_category_image_update_radio">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="" class="control-label mb-1"><br></label>
                                    <div class="form-check form-control" style="border-style: none">
                                        <input id="not_update_image_radio" class="form-check-input" type="radio"
                                            name="is_category_image_update_radio" value="no" checked>
                                        <label class="form-check-label" for="is_category_image_update_radio">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_image" class="control-label mb-1">Category Image</label>
                            <input id="category_image_field" name="category_image" type="file" class="form-control-file" aria-required="true"
                                aria-invalid="false" disabled required>
                            @error('category_image')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div><br>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="display_in_home[]" value="Yes" 
                                    @if ($category->display_in_home == 'Yes') checked @endif>
                                <label class="form-check-label" for="display_in_home">
                                    Display in Home
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            Submit
                        </button>
                    </form>
                </div>
			</div>
        </div>
    </div>
    <script>
        var update_image_radio = document.getElementById('update_image_radio');
        var not_update_image_radio = document.getElementById('not_update_image_radio');
        var category_image_field = document.getElementById('category_image_field');

        update_image_radio.addEventListener('click', function() {
            category_image_field.removeAttribute('disabled')
        })

        not_update_image_radio.addEventListener('click', function() {
            category_image_field.setAttribute('disabled', 'disabled');
            category_image_field.value = '';
        })
    </script>
    <!-- END DATA TABLE-->
	<a href="{{ route('admin.category') }}">
        <button type="button" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
            </svg>
            &nbsp;Back
        </button>
    </a>
    
@endsection
