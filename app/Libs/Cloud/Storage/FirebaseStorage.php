<?php

namespace App\Libs\Cloud\Storage;

use App\Config\Config;
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
    private static $UNIQUE_INSTANCE;
    private static $FIREBASE_BUCKET;
    private static $STORAGE_FOLDER_PATH = Config::FIREBASE_STORAGE_IMAGES_FOLDER . "/";

    private function __construct()
    {
        $storage = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->createStorage();
        static::$FIREBASE_BUCKET = $storage->getBucket();
    }

    public static function getInstance()
    {
        if (!static::$UNIQUE_INSTANCE) {
            static::$UNIQUE_INSTANCE = new static();
        }

        return static::$UNIQUE_INSTANCE;
    }

    public function upload($resource, $newResourcePath)
    {
        static::$FIREBASE_BUCKET->upload($resource, [
            'name' => static::$STORAGE_FOLDER_PATH . $newResourcePath
        ]);
    }

    public function delete($resourcePath)
    {
        static::$FIREBASE_BUCKET->object(static::$STORAGE_FOLDER_PATH . $resourcePath)
            ->delete();
    }
}
