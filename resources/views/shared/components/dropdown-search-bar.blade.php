<form class="form-header" action="{{ $searchFormUrl }}" method="GET">
    <div class="search-bar-wrapper">
        <select class="search-select-input" name="searchField">
            @foreach ($searchFieldMap as $key => $value) {
                <option value="{{ $key }}" @selected($key === $searchField)>{{ $value }}</option>
            @endforeach
        </select>
        <input class="au-input au-input--xl au-input--custom" type="text" name="searchKeyword"
            value="{{ $searchKeyword }}" placeholder="Search..."
            maxlength="{{ $searchKeywordMaxLength ?? Constants::SEARCH_KEYWORD_MAX_LENGTH }}">
        <button class="au-btn--submit" type="submit">
            <i class="zmdi zmdi-search"></i>
        </button>
    </div>
</form>
