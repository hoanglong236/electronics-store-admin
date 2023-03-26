@extends('shared.layouts.catalog-layout')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-5 mb-4">Brand</h2>
            @if (Session::has(Constants::ACTION_SUCCESS))
                @include('shared.components.action-success-label', [
                    'succeeMessage' => Session::get(Constants::ACTION_SUCCESS),
                ])
            @endif
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    @include('shared.components.search-bar', [
                        'searchFormUrl' => route('catalog.brand.search'),
                        'searchKeyword' => $data['searchKeyword'] ?? '',
                    ])
                </div>

                <div class="table-data__tool-right">
                    <a href="{{ route('catalog.brand.create') }}">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i>add item
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($data['brands'] as $brand)
            <div class="col-md-3">
                @include('pages.brand.components.brand-card')
            </div>
        @empty
            <div class="col-md-3">
                <span>No brand found.</span>
            </div>
        @endforelse
    </div>
@endsection
