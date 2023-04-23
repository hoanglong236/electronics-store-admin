<div class="overview-item {{ $overviewItemCSSClass }}">
    <div class="overview__inner">
        <div class="overview-box clearfix">
            <div class="icon">
                <i class="{{ $overviewIconCSSClass }}"></i>
            </div>
            <div class="text">
                <h2>{{ $overviewData }}</h2>
                <span>{{ $overviewTitle }}</span>
            </div>
        </div>
        <div class="overview-chart">
            <canvas id="{{ $overviewCharId }}"></canvas>
        </div>
    </div>
</div>
