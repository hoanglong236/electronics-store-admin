<form action="{{ $searchFormUrl }}" method="GET">
    <div class="search-bar-wrapper">
        <select class="au-select-input au-select-input--small" name="searchOption">
            @foreach ($searchOptions as $searchOption)
                <option value="{{ $searchOption }}" @selected($searchOption === $currentSearchOption)>
                    {{ $searchOption }}
                </option>
            @endforeach
        </select>
        <input class="au-input au-input--xl au-input--small" type="text" name="searchKeyword"
            value="{{ $searchKeyword }}" placeholder="Search..."
            maxlength="{{ $searchKeywordMaxLength ?? Constants::SEARCH_KEYWORD_MAX_LENGTH }}">
        <button class="au-btn--submit au-btn-custom--small" type="submit">
            <i class="zmdi zmdi-search"></i>
        </button>
    </div>

    <div class="filter-wrapper mt-3">
        <span>{{ $filterName }}</span>
        <select class="au-select-input au-select-input--small ml-4" name="filterOption">
            @foreach ($filterOptions as $filterOption)
                <option value="{{ $filterOption }}" @selected($filterOption === $currentFilterOption)>
                    {{ $filterOption }}
                </option>
            @endforeach
        </select>
    </div>
</form>
