@extends('layouts.base-layout')

@section('container')
    <h1>Category</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header">Update Category</div>
                <div class="card-body">
                    <form action="{{ route('catalog.category.update.handler', $category->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label mb-1">Category ID</label>
                            <input name="id" type="text" value="{{ $category->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Category Name</label>
                            <input name="name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $category->name }}" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="parent_id" class="control-label mb-1">Category Parent</label>
                            <select name="parent_id" class="form-select" aria-required="true" aria-invalid="false">
                                <option value="null">
                                    Select parent category
                                </option>
                                @foreach ($categories as $categoryItem)
                                    <option value="{{ $categoryItem->id }}" @selected($category->parent_id == $categoryItem->id)>
                                        {{ $categoryItem->name }}
                                    </option>
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
