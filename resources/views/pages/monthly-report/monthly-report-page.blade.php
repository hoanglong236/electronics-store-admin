@extends('shared.layouts.catalog-layout')

@section('container-content')
    <div class="row">
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1">overview</h2>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="white-bg-wrapper">
                @include('pages.monthly-report.components.report-search-wrapper', [
                    'month' => $data['month'],
                    'year' => $data['year'],
                    'searchUrl' => route('monthly-report.search'),
                ])
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="export-buttons-wrapper text-right d-flex-center-space-between-wrap">
                <div class="export-title">Export</div>
                @include('shared.components.buttons.excel-button', [
                    'conditionFields' => [
                        'month' => $data['month'],
                        'year' => $data['year'],
                    ],
                    'excelUrl' => route('monthly-report.export-excel'),
                ])
            </div>
        </div>
    </div>

    @php
        $monthlyReportData = $data['monthlyReportData'];
    @endphp

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="white-bg-wrapper">
                @include('pages.monthly-report.components.order-placed-chart', [
                    'orderPlacedDataset' => $monthlyReportData['orderPlacedDataset'],
                ])
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="white-bg-wrapper">
                <div class="row">
                    <div class="col-md-6">
                        @include('pages.monthly-report.components.best-seller-items-chart', [
                            'chartData' => [
                                'title' => 'Best-seller Brands',
                                'chartElementId' => 'bestSellerBrands',
                                'chartElementTitle' => 'Best-seller Brands Chart',
                                'bestSellerItems' => $monthlyReportData['bestSellerBrands'],
                            ],
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('pages.monthly-report.components.best-seller-items-chart', [
                            'chartData' => [
                                'title' => 'Best-seller Categories',
                                'chartElementId' => 'bestSellerCategories',
                                'chartElementTitle' => 'Best-seller Categories Chart',
                                'bestSellerItems' => $monthlyReportData['bestSellerCategories'],
                            ],
                        ])
                    </div>
                </div>

                <div class="row m-t-25">
                    <div class="col-md-12">
                        @include('pages.monthly-report.components.best-seller-items-chart', [
                            'chartData' => [
                                'title' => 'Best-seller Products',
                                'chartElementId' => 'bestSellerProducts',
                                'chartElementTitle' => 'Best-seller Products Chart',
                                'bestSellerItems' => $monthlyReportData['bestSellerProducts'],
                            ],
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($errors->any())
    <script>
        const message = '{{ implode(' ', $errors->all()) }}';
        alert(message);
    </script>
@endif
