<form class="form-header" action="{{ $searchFormUrl }}" method="GET">
    <input class="au-input au-input--xl" type="text" name="searchKeyword" value="{{ $searchKeyword }}"
        placeholder="Search brand name..." maxlength="64">
    <button class="au-btn--submit" type="submit">
        <i class="zmdi zmdi-search"></i>
    </button>
</form>
