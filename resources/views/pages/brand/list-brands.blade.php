@extends('layouts.base-layout')

@section('container')
    <h1>Brand</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive table--no-card m-b-30 brand_table">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td class="align-middle">{{ $brand->id }}</td>
                                <td class="align-middle">{{ $brand->name }}</td>
                                <td class="align-middle">
                                    <div class="brand_logo_container">
                                        <img class="brand_logo"
                                            src="{{ asset('/storage' . '/' . $brand->logo_path) }}">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="form-action-wrapper">
                                        <form class="form-action-wrapper_item" method="post" action="{{ route('catalog.brand.delete', [$brand->id]) }}">
                                            @csrf
                                            @method("delete")
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        <form class="form-action-wrapper_item" method="get" action="{{ route('catalog.brand.update', [$brand->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                            </button>
                                        </form>
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
    <a href="{{ route('catalog.brand.create') }}" class="mb-5">
        <button type="button" class="btn btn-success">Create brand</button>
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
