@extends('shared.layouts.catalog-layout')

@section('container')
    <a href="{{ route('manage.customer.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-lg-5">
            @include('pages.customer.components.customer-detail-card')
        </div>
    </div>

    <div class="row m-t-10">
        <div class="col-md-12">
            <div class="table-responsive m-b-40">
                @include('pages.customer.components.customer-address-table')
            </div>
        </div>
    </div>
@endsection
