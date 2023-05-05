@php
    // Require variables: $notEmptyChartElements, $dotCssClassArray, $chartElementCount
    $notEmptyChartElementCount = count($notEmptyChartElements);
    $defaultDotCssClassArray = [];
    $total = 0;
    foreach ($notEmptyChartElements as $index => $element) {
        $total += $element['value'];
        $defaultDotCssClassArray[] = 'dot dot--custom-' . ($index + 1);
    }
    $dotCssClassArray = $dotCssClassArray ?? $defaultDotCssClassArray;
@endphp

<table class="table chart-legend-table">
    <tbody>
        @foreach ($notEmptyChartElements as $element)
            <tr>
                <td>
                    <span class="{{ $dotCssClassArray[$loop->index] }}"></span>
                </td>
                <td>
                    <div class="text-truncate">{{ $element['label'] }}</div>
                </td>
                <td>{{ $element['value'] }}</td>
                <td>{{ round(($element['value'] / $total) * 100, 2) }}%</td>
            </tr>
        @endforeach
        @for ($i = $notEmptyChartElementCount; $i < $chartElementCount; $i++)
            <div class="row">
                <td>
                    <span class="{{ $dotCssClassArray[$i] }}"></span>
                </td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </div>
        @endfor
    </tbody>
</table>
