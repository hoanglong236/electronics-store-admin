@extends('shared.layouts.catalog-layout')

@section('container-content')
    <a href="{{ route('manage.customer.index') }}">
        <button type="button" class="btn btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
        </button>
    </a>

    <div class="row mt-4">
        <div class="col-md-8">
            @include('pages.customer.components.customer-info-table', [
                'customerInfo' => $data['customerDetails']['customerInfo'],
            ])
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            @include('pages.customer.components.customer-address-table', [
                'customerAddresses' => $data['customerDetails']['addresses'],
            ])
        </div>
    </div>
@endsection
