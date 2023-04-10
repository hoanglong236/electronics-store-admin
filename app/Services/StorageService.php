<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function saveFile($file, $path)
    {
        $fileName = mt_rand() . time() . '.' . $file->getClientOriginalExtension();
        $filePath = Storage::putFileAs($path, $file, $fileName);
        return $filePath;
    }

    public function deleteFile($filePath) {
        Storage::delete($filePath);
    }
}
