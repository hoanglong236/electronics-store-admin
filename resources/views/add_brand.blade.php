@extends('admin.layout')

@section('container')
    <h1>Brand</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Brand</div>
                <div class="card-body">
                    <form action="{{ route('admin.brand.add_brand_handle') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="brand_name" class="control-label mb-1">Brand Name</label>
                            <input name="brand_name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" required>
                            @error('brand_name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand_slug" class="control-label mb-1">Brand Slug</label>
                            <input name="brand_slug" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" required>
                            @error('brand_slug')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand_logo" class="control-label mb-1">Brand Logo</label>
                            <input name="brand_logo" type="file" class="form-control-file" aria-required="true"
                                aria-invalid="false" required>
                            @error('brand_logo')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div><br>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="display_in_home[]" value="Yes">
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
    <!-- END DATA TABLE-->
    <a href="{{ route('admin.brand') }}">
        <button type="button" class="btn btn-success">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
            </svg> --}}
            <span class="material-symbols-outlined">
                arrow_back
            </span>
            &nbsp;Back
        </button>
    </a>
@endsection
