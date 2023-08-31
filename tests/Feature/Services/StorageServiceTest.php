<?php

namespace Tests\Feature\Services;

use App\Services\StorageService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StorageServiceTest extends TestCase
{
    private $storageService;

    private function allTestSetup(): void
    {
        $this->storageService = app(StorageService::class);
    }

    public function test_file_should_be_stored_to_public_disk(): void
    {
        // Setup
        $this->allTestSetup();
        $fakeFile = UploadedFile::fake()->createWithContent('fake-file.txt', 'Fake file content');
        $containingFolderPath = 'test-files';

        // Run
        $fullFilePath = public_path('storage') . "\\"
            . $this->storageService->saveFile($fakeFile, $containingFolderPath, false);

        // Asserts
        $this->assertTrue(file_exists($fullFilePath));

        // Clean up
        unlink($fullFilePath);
    }

    public function test_file_should_be_stored_to_public_disk_even_with_cloud_storage_enabled(): void
    {
        // Setup
        $this->allTestSetup();
        $fakeFile = UploadedFile::fake()->createWithContent('fake-file.txt', 'Fake file content');
        $containingFolderPath = 'test-files';

        // Run
        $fullFilePath = public_path('storage') . "\\"
            . $this->storageService->saveFile($fakeFile, $containingFolderPath);

        // Asserts
        $this->assertTrue(file_exists($fullFilePath));

        // Clean up
        unlink($fullFilePath);
    }

    public function test_file_should_be_deleted_from_public_disk(): void
    {
        // Setup
        $this->allTestSetup();
        $containingFolderPath = 'test-files';
        $fakeFilePath = UploadedFile::fake()->image('fake-file.png')->store($containingFolderPath);

        $fullFilePath = public_path('storage') . "\\" . $fakeFilePath;
        $isFileExists = file_exists($fullFilePath);

        // Run
        $isDeleteSuccess = $this->storageService->deleteFile($fakeFilePath, false);

        // Asserts
        $this->assertTrue($isFileExists);
        $this->assertTrue($isDeleteSuccess);
        $this->assertFalse(file_exists($fullFilePath));
    }

    public function test_it_should_not_be_failed_when_file_to_delete_not_exist(): void
    {
        // Setup
        $this->allTestSetup();
        $filePath = 'not-exist-folder\\not-exist-file.txt';

        $fullFilePath = public_path('storage') . "\\" . $filePath;
        $isFileExists = file_exists($fullFilePath);

        // Run
        $isDeleteSuccess = $this->storageService->deleteFile($filePath, false);

        // Asserts
        $this->assertFalse($isFileExists);
        $this->assertFalse($isDeleteSuccess);
    }

    public function test_it_should_not_be_failed_when_file_to_delete_not_exist_in_cloud(): void
    {
        // Setup
        $this->allTestSetup();
        $containingFolderPath = 'test-files';
        $fakeFilePath = UploadedFile::fake()->image('fake-file.png')->store($containingFolderPath);

        $fullFilePath = public_path('storage') . "\\" . $fakeFilePath;
        $isFileExists = file_exists($fullFilePath);

        // Run
        $isDeleteSuccess = $this->storageService->deleteFile($fakeFilePath);

        // Asserts
        $this->assertTrue($isFileExists);
        $this->assertTrue($isDeleteSuccess);
        $this->assertFalse(file_exists($fullFilePath));
    }
}
