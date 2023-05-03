@include('pages.dashboard.components.base-overview-area', [
    'overviewItemCSSClass' => 'overview-item--c3',
    'overviewIconCSSClass' => 'zmdi zmdi-calendar-note',
    'overviewData' => $overviewData,
    'overviewTitle' => 'orders placed',
    'overviewCharId' => 'widgetChart3',
])
