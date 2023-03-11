@extends('shared.layouts.catalog-layout')

@section('container')
    <a href="{{ route('catalog.category.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-6">
            @include('pages.category.components.update-category-form')
        </div>
    </div>
@endsection
