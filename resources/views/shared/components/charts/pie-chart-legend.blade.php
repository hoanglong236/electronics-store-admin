@php
    // Require variables: $notEmptyChartElements, $chartElementColors, $chartElementCount
    $notEmptyChartElementCount = count($notEmptyChartElements);
    $total = 0;
    foreach ($notEmptyChartElements as $element) {
        $total += $element['value'];
    }
@endphp

<table class="table table-borderless pie-chart-legend-wrapper">
    <tbody>
        @foreach ($notEmptyChartElements as $index => $element)
            <tr>
                <td>
                    <span class="dot" style="background-color: {{ $chartElementColors[$index] }}"></span>
                </td>
                <td>{{ $element['label'] }}</td>
                <td>
                    {{ is_int($element['value']) ? number_format($element['value']) : number_format($element['value'], 3) }}
                </td>
                <td>{{ round(($element['value'] / $total) * 100, 2) }}%</td>
            </tr>
        @endforeach
        @for ($i = $notEmptyChartElementCount; $i < $chartElementCount; $i++)
            <tr>
                <td>
                    <span class="dot" style="background-color: {{ $chartElementColors[$index] }}"></span>
                </td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        @endfor
    </tbody>
</table>
