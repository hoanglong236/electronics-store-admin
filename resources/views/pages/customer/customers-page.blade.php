@extends('shared.layouts.catalog-layout')

@section('container-content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-5 mb-4">Customer</h2>
            @if (Session::has(Constants::ACTION_SUCCESS))
                @include('shared.components.action-success-label', [
                    'succeeMessage' => Session::get(Constants::ACTION_SUCCESS),
                ])
            @endif
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    @include('shared.components.search-bar', [
                        'searchFormUrl' => route('manage.customer.search'),
                        'searchKeyword' => $data['searchKeyword'],
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($data['customers'] as $customer)
            <div class="col-xl-3 col-sm-4">
                @include('pages.customer.components.customer-card')
            </div>
        @empty
            <div class="col-md-3">
                <span>No customer found.</span>
            </div>
        @endforelse
    </div>

    @include('shared.components.pagination-nav', ['paginator' => $data['paginator']])
@endsection
