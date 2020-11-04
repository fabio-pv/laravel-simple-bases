<?php


namespace LaravelSimpleBases\Services;


use Illuminate\Support\Facades\Storage;
use LaravelSimpleBases\Models\File;
use LaravelSimpleBases\Utils\FileInterceptorUtil;
use Webpatser\Uuid\Uuid;

trait FileInterceptor
{
    private $fantasyProperty;
    private $saveLocation;
    private $extension;
    private $lastUuid;


    private function initializeVariable()
    {
        $config = config('model_with_file')[get_class($this->model)] ?? null;
        if (empty($config)) {
            return;
        }
        $this->fantasyProperty = $config['fantasy_property'];
        $this->saveLocation = FileInterceptorUtil::getSaveLocation($this->model);
        $this->extension = $config['extension'];
    }

    protected function interceptFile()
    {

        $this->initializeVariable();

        $photoOrPhotos = $this->lastRealData[$this->fantasyProperty] ?? null;
        $photoOrPhotosUuid = $this->lastRealData[$this->fantasyProperty . '_uuid'] ?? null;

        if (empty($photoOrPhotos)) {
            return;
        }

        if (is_array($photoOrPhotos)) {
            foreach ($photoOrPhotos as $photo) {
                $this->executeInterceptFile($photo);
            }
            return;
        }

        $this->executeInterceptFile($photoOrPhotos, $photoOrPhotosUuid);
        return;

    }

    private function executeInterceptFile($photo, $photo_uuid = null)
    {
        $result = $this->deleteFileInDB($photo, $photo_uuid);
        if ($result === true) {
            return;
        }

        $fileName = $this->makeFileName();
        $content = $this->makeContentFile($photo);
        $this->saveFile($fileName, $content);
        $this->saveFileNameInDB($photo_uuid);
    }

    private function makeFileName()
    {
        $this->lastUuid = Uuid::generate()->string;

        return $this->saveLocation
            . '/'
            . $this->lastUuid
            . $this->extension;
    }

    private function makeContentFile(string $photo)
    {
        return base64_decode($photo);
    }

    private function saveFile(string $fileName, $content)
    {
        Storage::put($fileName, $content);
    }

    private function saveFileNameInDB($photo_uuid = null)
    {
        $file = new File();

        if (!empty($photo_uuid)) {
            $file = File::findByUuid($photo_uuid);
        }

        $file->file = $this->lastUuid;
        $file->extension = $this->extension;
        $file->reference_id = $this->model->id;
        $file->reference = get_class($this->model);
        $file->save();

    }

    private function deleteFileInDB($photo, $photo_uuid = null): bool
    {

        if ($photo !== 'null') {
            return false;
        }

        $file = File::findByUuid($photo_uuid);
        $file->delete();

        return true;

    }
}
