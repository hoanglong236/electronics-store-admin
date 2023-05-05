@php
    // Require variables: $notEmptyChartElements, $dotCssClassArray, $chartElementCount
    $notEmptyChartElementCount = count($notEmptyChartElements);
    $total = 0;
    foreach ($notEmptyChartElements as $element) {
        $total += $element['value'];
    }

    if ($dotCssClassArray ?? true) {
        $defaultDotCssClassArray = [];
        for ($i = 0; $i < $chartElementCount; $i++) {
            $defaultDotCssClassArray[] = 'dot dot--custom-' . ($i + 1);
        }

        $dotCssClassArray = $defaultDotCssClassArray;
    }

@endphp

<table class="table chart-legend-table">
    <tbody>
        @foreach ($notEmptyChartElements as $index => $element)
            <tr>
                <td>
                    <span class="{{ $dotCssClassArray[$index] }}"></span>
                </td>
                <td>{{ $element['label'] }}</td>
                <td>{{ $element['value'] }}</td>
                <td>{{ round(($element['value'] / $total) * 100, 2) }}%</td>
            </tr>
        @endforeach
        @for ($i = $notEmptyChartElementCount; $i < $chartElementCount; $i++)
            <tr>
                <td>
                    <span class="{{ $dotCssClassArray[$i] }}"></span>
                </td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        @endfor
    </tbody>
</table>
