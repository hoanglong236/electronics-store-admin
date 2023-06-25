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
                @include('pages.monthly-report.components.orders-summary-section', [
                    'ordersSummary' => $monthlyReportData['ordersSummary'],
                ])
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="white-bg-wrapper">
                @include('pages.monthly-report.components.orders-analysis-section', [
                    'ordersAnalysis' => $monthlyReportData['ordersAnalysis'],
                ])
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="white-bg-wrapper">
                @include('pages.monthly-report.components.best-sellers-section', [
                    'bestSellers' => $monthlyReportData['bestSellers'],
                ])
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
