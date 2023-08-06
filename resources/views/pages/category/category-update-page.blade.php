@extends('shared.layouts.catalog-layout')

@section('container-content')
    @include('shared.components.buttons.back-button', [
        'backUrl' => route('catalog.category.index'),
    ])

    <div class="row mt-4">
        <div class="col-lg-6">
            @include('pages.category.components.category-update-card', [
                'category' => $data['category'],
                'parentCategoryMap' => $data['parentCategoryMap'],
            ])
        </div>
    </div>
@endsection
