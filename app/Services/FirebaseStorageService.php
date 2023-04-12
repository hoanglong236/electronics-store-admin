<?php

namespace App\Services;

use App\Common\Constants;
use Kreait\Firebase\Factory;

/**
 * Firebase configuration steps:
 * - Require firebase library: composer require kreait/laravel-firebase
 * - Download service accounts private key:
 *   ... > Project settings > Service accounts > Pick Node js > Generate new private key => json file
 * - Put json file above to the \storage\app\public\credentials\ folder
 * - Put FIREBASE_CREDENTIALS = \storage\app\public\credentials\<json-file-name>.json to .env file
 */
class FirebaseStorageService
{
    private $firebaseStorage;
    private $firebaseBucket;

    public function __construct()
    {
        $this->firebaseStorage = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->createStorage();
        $this->firebaseBucket = $this->firebaseStorage->getBucket();
    }

    public function uploadImage($imagePath)
    {
        $imageResource = fopen(public_path('/storage/') . $imagePath, "r");
        $this->firebaseBucket->upload($imageResource, [
            'name' => Constants::FIREBASE_STORAGE_IMAGES_PATH . $imagePath,
        ]);
    }

    public function deleteImage($imagePath)
    {
        $this->firebaseBucket->object(Constants::FIREBASE_STORAGE_IMAGES_PATH . $imagePath)->delete();
    }
}
