@extends('admin.layout')

@section('container')
    <h1>Brand</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Brand</div>
                <div class="card-body">
                    <form action="{{ route('admin.brand.update_brand_handle') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label mb-1">Brand ID</label>
                            <input name="id" type="text" value="{{ $brand->id }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="brand_name" class="control-label mb-1">Brand Name</label>
                            <input name="brand_name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $brand->brand_name }}" required>
                            @error('brand_name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand_slug" class="control-label mb-1">Brand Slug</label>
                            <input name="brand_slug" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $brand->brand_slug }}" required>
                            @error('brand_slug')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="" class="control-label mb-1">Update Brand Logo?</label>
                                    <div class="form-check form-control" style="border-style: none">
                                        <input id="update_logo_radio" class="form-check-input" type="radio"
                                            name="is_brand_logo_update_radio" value="yes">
                                        <label class="form-check-label" for="is_brand_logo_update_radio">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="" class="control-label mb-1"><br></label>
                                    <div class="form-check form-control" style="border-style: none">
                                        <input id="not_update_logo_radio" class="form-check-input" type="radio"
                                            name="is_brand_logo_update_radio" value="no" checked>
                                        <label class="form-check-label" for="is_brand_logo_update_radio">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="brand_logo" class="control-label mb-1">Brand Logo</label>
                            <input id="brand_logo_field" name="brand_logo" type="file" class="form-control-file"  aria-required="true"
                                aria-invalid="false" disabled required>
                            @error('brand_logo')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="display_in_home[]" value="Yes" 
                                    @if ($brand->display_in_home == 'Yes') checked @endif>
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
        var update_logo_radio = document.getElementById('update_logo_radio');
        var not_update_logo_radio = document.getElementById('not_update_logo_radio');
        var brand_logo_field = document.getElementById('brand_logo_field');

        update_logo_radio.addEventListener('click', function() {
            // console.log(brand_logo_field.value);
            // if (brand_logo_field.value == null) console.log('null ne')
            // if (brand_logo_field.value == '') console.log('rong ne')
            brand_logo_field.removeAttribute('disabled')
        })

        not_update_logo_radio.addEventListener('click', function() {
            brand_logo_field.setAttribute('disabled', 'disabled');
            brand_logo_field.value = '';
            // console.log(brand_logo_field.value);
        })
    </script>
    <!-- END DATA TABLE-->
	<a href="{{ route('admin.brand') }}">
        <button type="button" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
            </svg>
            &nbsp;Back
        </button>
    </a>
    
@endsection
