@extends('admin.layout')

@section('container')
    <h1>Slider</h1><br>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Slider</div>
                <div class="card-body">
                    <form action="{{ route('admin.slider.add_slider_handle') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="control-label mb-1">Title</label>
                            <input name="title" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" required>
                        </div>
                        <div class="form-group">
                            <label for="discount_title" class="control-label mb-1">Discount Title</label>
                            <input name="discount_title" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" required>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Image</label>
                            <input name="image" type="file" class="form-control-file"  aria-required="true"
                                aria-invalid="false" required>
                            @error('image')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_slug" class="control-label mb-1">Category Name</label>
                            <select name="category_slug" class="form-select" aria-required="true" aria-invalid="false"
                                required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_slug }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DATA TABLE-->
    <a href="{{ route('admin.slider') }}">
        <button type="button" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z" />
            </svg>
            &nbsp;Back
        </button>
    </a>
@endsection


                            