@php
    $totalSoldQuantity = $category->soldQuantity;
    $othersSoldQuantity = $totalSoldQuantity;
    $drawChartParams = "'bestSellingBrandsChart" . $category->id . "', 'Best-selling Brands In " . $category->name . "', ";

    foreach ($brands as $brand) {
        $othersSoldQuantity -= $brand->soldQuantity;
        $drawChartParams .= "'" . $brand->name . "', " . $brand->soldQuantity . ', ';
    }
    if ($othersSoldQuantity > 0) {
        $drawChartParams .= "'Others', " . $othersSoldQuantity;
    }
@endphp

<div class="row">
    <div class="col-md-12 mb-2">
        <table class="table order-chart-legend-table">
            <tbody>
                @foreach ($brands as $index => $brand)
                    <tr>
                        <td><span class="dot dot--custom-{{ $index + 1 }}"></span></td>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->soldQuantity }}</td>
                        <td>{{ round(($brand->soldQuantity / $totalSoldQuantity) * 100, 2) }}%</td>
                    </tr>
                @endforeach
                @if ($othersSoldQuantity > 0)
                    <tr>
                        <td><span class="dot dot--custom-{{ Constants::BEST_SELLING_BRANDS_LIMIT + 1 }}"></span></td>
                        <td>Others</td>
                        <td>{{ $othersSoldQuantity }}</td>
                        <td>{{ round(($othersSoldQuantity / $totalSoldQuantity) * 100, 2) }}%</td>
                    </tr>
                @else
                    @for ($i = count($brands->all()); $i < Constants::BEST_SELLING_BRANDS_LIMIT + 1; $i++)
                    <tr>
                        <td><span class="dot dot--custom-{{ $i + 1 }}"></span></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <canvas id="bestSellingBrandsChart{{ $category->id }}"></canvas>
    </div>
</div>

@push('scripts')
    @once
        <script src="{{ asset('assets/js/best-selling-brands-chart.js') }}"></script>
    @endonce
    <script>
        drawBestSellingBrandsChart({!! $drawChartParams !!});
    </script>
@endpush
