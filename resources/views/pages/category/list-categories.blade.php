@extends('layouts.base-layout')

@section('container')
    <h1>Category</h1><br>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Parent ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="align-middle">{{ $category->id }}</td>
                                <td class="align-middle">{{
                                    is_null($category->parent_id) ? "None" : $category->parent_id
                                }}</td>
                                <td class="align-middle">{{ $category->name }}</td>
                                <td class="align-middle">
                                    <div class="form-action-wrapper">
                                        <form class="form-action-wrapper_item" method="post"
                                            action="{{ route('catalog.category.delete', [$category->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        <form class="form-action-wrapper_item" method="get"
                                            action="{{ route('catalog.category.update', [$category->id]) }}">
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
    <!-- END DATA TABLE-->
    <a href="{{ route('catalog.category.create') }}">
        <button type="button" class="btn btn-success">Add Category</button>
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
