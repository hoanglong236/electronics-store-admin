<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function saveFile($file, string $folderPath)
    {
        $fileName = mt_rand() . time() . '.' . $file->getClientOriginalExtension();
        $filePath = Storage::putFileAs($folderPath, $file, $fileName);
        return $filePath;
    }

    public function deleteFile(string $filePath) {
        Storage::delete($filePath);
    }
}
