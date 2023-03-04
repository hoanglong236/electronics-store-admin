@extends('layouts.catalog-layout')

@section('container')
    <a href="{{ route('catalog.brand.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <strong>Update Brand</strong>
                </div>
                <form action="{{ route('catalog.brand.update.handler', $brand->id) }}" method="post"
                    enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label class=" form-control-label">Brand name</label>
                            <input type="text" name="name" value="{{ $brand->name }}" class="form-control" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=" form-control-label">New brand logo?</label>
                            <input type="file" name="logo" class="form-control-file" required>
                            @error('logo')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
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
        </div>
    </div>
@endsection
