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
                    <form class="form-header" action="{{ route('catalog.brand.search') }}" method="GET">
                        <input class="au-input au-input--xl" type="text" name="keyword" value="{{ $keyword ?? '' }}"
                            placeholder="Search brand name..." maxlength="64">
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
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
        @forelse ($brands as $brand)
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
