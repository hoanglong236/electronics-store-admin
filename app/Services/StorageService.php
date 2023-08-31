<?php

namespace App\Services;

use App\Libs\Cloud\Storage\FirebaseStorage;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    private $firebaseStorage;

    public function __construct()
    {
        $this->firebaseStorage = new FirebaseStorage();
    }

    /**
     * Save file to the public disk storage. If $storeToCloud is true, the file will also be
     * saved to the cloud storage.
     *
     * @param UploadedFile $file File to save
     * @param bool $storeToCloud Whether to store the file in the cloud storage
     *
     * @return string|bool Returns false if could not save the file, otherwise
     *   returns relative file path in public disk storage
     */
    public function saveFile(UploadedFile $file, string $folderPath, bool $storeToCloud = true)
    {
        $fileName = mt_rand() . time() . '.' . $file->getClientOriginalExtension();
        $filePath = Storage::putFileAs($folderPath, $file, $fileName);
        if (!$filePath) {
            logger()->error('Could not save file. Storage folder: ' . $folderPath . ' - File: ' . $file);
            return false;
        }

        $filePath = str_replace("/", "\\", $filePath);
        if ($storeToCloud) {
            $resource = fopen(public_path('storage') . "\\" . $filePath, "r");
            try {
                $this->firebaseStorage->upload($resource, $filePath);
            } catch (Exception $e) {
                logger()->error($e);
            }
        }
        return $filePath;
    }

    /**
     * Delete a file from the public disk storage. If $deleteFromCloud is true,
     * the file will also be deleted in the cloud storage.
     *
     * @param string $filePath Relative file path in the public disk storage
     * @param bool $deleteFromCloud Whether to delete the file from the cloud storage
     *
     * @return bool Returns false if the file is not found in the public disk storage.
     *   Returns true if the file is deleted successfully in the public disk storage.
     */
    public function deleteFile(string $filePath, bool $deleteFromCloud = true)
    {
        $fullFilePath = public_path('storage') . "\\" . $filePath;
        if (!file_exists($fullFilePath)) {
            logger()->error('File not found: ' . $fullFilePath);
            return false;
        }

        Storage::delete($filePath);
        if ($deleteFromCloud) {
            try {
                $this->firebaseStorage->delete($filePath);
            } catch (Exception $e) {
                logger()->error($e);
            }
        }
        return true;
    }
}
