@php
    $fromDateInputId = $fromDateInputName . 'Id';
    $toDateInputId = $toDateInputName . 'Id';
@endphp
<div class="date-range-wrapper">
    <div class="date-range-group">
        <label for="{{ $fromDateInputId }}" class="date-range-label">{{ $label }}:</label>
        <input id="{{ $fromDateInputId }}" type="date" name="{{ $fromDateInputName }}" value="{{ $fromDate }}"
            class="form-control" required>
    </div>
    <div class="date-range-group ml-4">
        <label for="{{ $toDateInputId }}" class="date-range-label mr-4">To</label>
        <input id="{{ $toDateInputId }}" type="date" name="{{ $toDateInputName }}" value="{{ $toDate }}"
            class="form-control" required>
    </div>
</div>
