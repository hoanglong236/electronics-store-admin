<?php

namespace App\Services;

use App\Libs\Cloud\Storage\FirebaseStorage;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    private $firebaseStorage;

    public function __construct()
    {
        $this->firebaseStorage = new FirebaseStorage();
    }

    public function saveFile($file, string $folderPath, bool $storeToCloud = true)
    {
        $fileName = mt_rand() . time() . '.' . $file->getClientOriginalExtension();
        $filePath = Storage::putFileAs($folderPath, $file, $fileName);

        if ($storeToCloud) {
            $resource = fopen(public_path('storage/') . $filePath, "r");
            $this->firebaseStorage->upload($resource, $filePath);
        }
        return $filePath;
    }

    public function deleteFile(string $filePath, bool $deleteFromCloud = true)
    {
        Storage::delete($filePath);
        if ($deleteFromCloud) {
            $this->firebaseStorage->delete($filePath);
        }
    }
}
