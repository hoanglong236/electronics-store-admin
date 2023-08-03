<div class="overview-panel white-bg-wrapper">
    <div class="overview-panel__main">
        <div class="overview-panel__icon-wrapper">
            <img src="{{ $imageUrl ?? asset('assets/images/icon/question.png') }}" alt="Icon">
        </div>
        <div class="overview-panel__content-wrapper">
            <div class="overview-panel__title">{{ $title }}</div>
            <div class="overview-panel__data">{{ $currentData ?? '--' }}</div>
        </div>
    </div>

    <div class="overview-panel__compare mt-2">
        @if ($compareText ?? false)
            <span class="{{ $compareCSSClass }}">{{ $compareText }}</span>
        @endif
    </div>
</div>
