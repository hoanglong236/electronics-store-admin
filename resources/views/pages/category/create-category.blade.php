@extends('layouts.base-layout')

@section('container')
    <h1>Category</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header">Add Category</div>
                <div class="card-body">
                    <form action="{{ route('catalog.category.create.handler') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Category Name</label>
                            <input name="name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="parentId" class="control-label mb-1">Parent category</label>
                            <select name="parentId" class="form-select" aria-required="true" aria-invalid="false">
                                <option value="null">
                                    Select parent category
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-lg btn-info btn-block mt-3 mb-1">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DATA TABLE-->
    <a href="{{ route('catalog.category.index') }}">
        <button type="button" class="btn btn-success">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>
@endsection
