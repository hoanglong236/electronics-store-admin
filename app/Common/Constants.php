<?php

namespace App\Common;

class Constants
{
    const ACTION_SUCCESS = 'success_message';
    const ACTION_ERROR = 'error_message';

    const LOGIN_DETAIL_INVALID = 'Please enter valid login details.';
    const LOGOUT_SUCCESS = 'Logout successfully.';
    const REGISTER_SUCCESS = 'Register successfully.';

    const CREATE_SUCCESS = 'Create successfully.';
    const UPDATE_SUCCESS = 'Update successfully.';
    const DELETE_SUCCESS = 'Delete successfully.';

    const NONE_VALUE = 'none';

    const DEFAULT_ITEM_PAGE_COUNT = 12;

    const SEARCH_KEYWORD_MAX_LENGTH = 64;

    const BEST_SELLING_CATEGORIES_LIMIT = 3;
    const BEST_SELLING_BRANDS_LIMIT = 3;

    private function __construct()
    {
    }
}
