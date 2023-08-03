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
        @if ($previousData ?? false)
            @if ($previousData < $currentData)
                <span>GT</span>
            @elseif ($previousData > $currentData)
                <span>LT</span>
            @else
                <span>EQ</span>
            @endif
        @endif
    </div>
</div>
