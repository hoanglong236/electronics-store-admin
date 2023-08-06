<?php

namespace App\Services;

use App\Libs\Cloud\Storage\FirebaseStorage;

class FirebaseStorageService
{
    private $firebaseStorage;

    public function __construct()
    {
        $this->firebaseStorage = new FirebaseStorage();
    }

    public function uploadImage(string $imagePath)
    {
        $imageResource = fopen(public_path('/storage/') . $imagePath, "r");
        $this->firebaseStorage->upload($imageResource, $imagePath);
    }

    public function deleteImage(string $imagePath)
    {
        $this->firebaseStorage->delete($imagePath);
    }
}
