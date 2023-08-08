<?php

namespace App\Libs\Cloud\Storage;

use App\Constants\ConfigConstants;
use Kreait\Firebase\Factory;

/**
 * Firebase configuration steps:
 * - Require firebase library: composer require kreait/laravel-firebase
 *   -> Must enable extension=sodium in php.ini
 * - Download service accounts private key:
 *   ... > Project settings > Service accounts > Pick Node js > Generate new private key => json file
 * - Put json file above to the \storage\app\public\credentials\ folder
 * - Put FIREBASE_CREDENTIALS = \storage\app\public\credentials\<json-file-name>.json to .env file
 */
class FirebaseStorage
{
    private static $STORAGE_FOLDER_PATH = ConfigConstants::FOLDER_PATH_FIREBASE_STORAGE_IMAGES . "/";

    private $firebaseBucket;

    public function __construct()
    {
        $storage = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->createStorage();
        $this->firebaseBucket = $storage->getBucket();
    }

    public function upload($resource, $resourcePath)
    {
        $this->firebaseBucket->upload($resource, [
            'name' => static::$STORAGE_FOLDER_PATH . $resourcePath
        ]);
    }

    public function delete($resourcePath)
    {
        $this->firebaseBucket->object(static::$STORAGE_FOLDER_PATH . $resourcePath)
            ->delete();
    }
}
