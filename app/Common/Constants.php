<?php

namespace App\Common;

use App\ModelConstants\OrderStatusConstants;

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

    const BRAND_LOGO_PATH = 'brand_logos';
    const CATEGORY_ICON_PATH = 'category_icons';
    const PRODUCT_IMAGE_PATH = 'product_images';

    const NONE_VALUE = 'none';

    const PRODUCT_PAGE_COUNT = 8;
    const CUSTOMER_PAGE_COUNT = 8;

    const SEARCH_KEYWORD_MAX_LENGTH = 64;

    const ORDER_STATUS_RECEIVED = OrderStatusConstants::RECEIVED;
    const ORDER_STATUS_PROCESSING = OrderStatusConstants::PROCESSING;
    const ORDER_STATUS_DELIVERING = OrderStatusConstants::DELIVERING;
    const ORDER_STATUS_COMPLETED = OrderStatusConstants::COMPLETED;
    const ORDER_STATUS_CANCELLED = OrderStatusConstants::CANCELLED;

    const FIREBASE_STORAGE_IMAGES_PATH = 'project_images/';

    private function __construct()
    {
    }
}
