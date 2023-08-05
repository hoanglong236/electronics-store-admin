<?php

namespace App\Constants;

class ConfigConstants
{
    const FOLDER_PATH_BRAND_LOGOS = 'brand_logos';
    const FOLDER_PATH_CATEGORY_ICONS = 'category_icons';
    const FOLDER_PATH_PRODUCT_IMAGES = 'product_images';
    const FOLDER_PATH_FIREBASE_STORAGE_IMAGES = 'project_images';

    const APP_TIMEZONE = 'Asia/Ho_Chi_Minh';

    const DEFAULT_ITEM_PAGE_COUNT = 12;
    const SEARCH_KEYWORD_MAX_LENGTH = 64;
    const BEST_SELLER_ITEMS_LIMIT = 3;

    private function __construct()
    {
    }
}
