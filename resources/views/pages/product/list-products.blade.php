@extends('layouts.base-layout')

@section('container')
    <h1>Product</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning my-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="align-middle">{{ $product->id }}</td>
                                <td class="align-middle">
                                    <div class="product_image_container">
                                        <img class="product_image" src="{{ asset('/storage' . '/' . $product->main_image_path) }}">
                                    </div>
                                </td>
                                <td class="align-middle">{{ $product->name }}</td>
                                <td class="align-middle">
                                    <div class="form-action-wrapper">
                                        <form class="form-action-wrapper_item" method="post"
                                            action="{{ route('catalog.product.delete', [$product->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        <form class="form-action-wrapper_item" method="get"
                                            action="{{ route('catalog.product.update', [$product->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        {{-- <form class="form-action-wrapper_item" method="get"
                                            action="{{ route('catalog.product.detail', [$product->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </button>
                                        </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
    <!-- END DATA TABLE-->
    <a href="{{ route('catalog.product.create') }}">
        <button type="button" class="btn btn-success">Add Product</button>
    </a>
    @if (Session::has(Constants::ACTION_ERROR))
        <script>
            alert("{{ Session::get(Constants::ACTION_ERROR) }}");
        </script>
    @elseif (Session::has(Constants::ACTION_SUCCESS))
        <script>
            alert("{{ Session::get(Constants::ACTION_SUCCESS) }}");
        </script>
    @endif
@endsection
