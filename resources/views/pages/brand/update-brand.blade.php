@extends('layouts.base-layout')

@section('container')
    <h1>Brand</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Brand</div>
                <div class="card-body">
                    <form action="{{ route('catalog.brand.update.handler', $brand->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="control-label mb-1">Brand ID</label>
                            <input type="text" value="{{ $brand->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Brand Name</label>
                            <input name="name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $brand->name }}" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="logo" class="control-label mb-1">Brand Logo</label>
                            <input name="logo" type="file" class="form-control-file"
                                aria-required="true" aria-invalid="false">
                            @error('logo')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('catalog.brand.index') }}">
        <button type="button" class="btn btn-success">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>
@endsection
