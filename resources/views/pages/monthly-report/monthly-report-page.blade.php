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
@endsection
