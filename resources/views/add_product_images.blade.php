@extends('admin.layout')

@section('container')
    <h1>Add Product Images</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive table--no-card m-b-30 product_table">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product ID</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($image_data as $product_image)
                            <tr>
                                <td class="align-middle">{{ $product_image->id }}</td>
                                <td class="align-middle">{{ $product_image->product_id }}</td>
                                <td class="align-middle">
                                    <div class="product_image_container">
                                        <img class="product_image"
                                            src="{{ asset('/storage/product_image/' . $product_image->image) }}">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.product_detail.delete_product_image', [$product_image->id]) }}"><button
                                            type="button" class="btn btn-danger btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
            {{-- ADD IMAGE FORM --}}
            <div class="card">
                <div class="card-header">Add Product Images</div>
                <div class="card-body">
                    <form action="{{ route('admin.product_detail.add_product_images_handle') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="product_id" class="control-label mb-1">Product ID</label>
                            <input name="product_id" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $product_id }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Select Product Images</label>
                            <input id="product_images" name="image[]" type="file" class="form-control-file"  aria-required="true"
                                aria-invalid="false" multiple required>
                            @error('image')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($errors->has('image.*'))
                                <div class="alert alert-danger">
                                    <ul>
                                        @php 
                                            $image_errors = $errors->all();           
                                        @endphp
                                        @foreach ($image_errors as $key => $val)
                                            @if (str_contains($val, 'image.')) 
                                                <li>{{ $val }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div><br>
                        <p>Selected files:</p>
                        <div id="fileList"></div><br>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DATA TABLE-->
    {{-- js for alert (sweet alert 2) --}}
    <script>
        var product_images = document.getElementById('product_images');
        var fileList = document.getElementById('fileList');

        product_images.addEventListener('change', function(){
            var fileNames = "";
            for (var i = 0; i < product_images.files.length; ++i) {
                fileNames += '<li>' + product_images.files.item(i).name + '</li>';
            }
            fileList.innerHTML = '<ul>'+fileNames+'</ul>';
        })
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var has_alert = '{{ Session::has('alert') }}';
        if (has_alert) {
            var alert_message = '{{ Session::get('alert') }}';
            if (alert_message.indexOf("Error") == -1) {
                Swal.fire(
                    'Successfully!',
                    alert_message,
                    'success'
                )
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: $alert_message,
                })
            }

        }
    </script>
    <a href="{{ route('admin.product_detail', [$product_id]) }}">
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
