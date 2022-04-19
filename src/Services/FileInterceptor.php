<?php


namespace LaravelSimpleBases\Services;


use Illuminate\Support\Facades\Storage;
use LaravelSimpleBases\Models\File;
use LaravelSimpleBases\Utils\FileInterceptorUtil;
use Webpatser\Uuid\Uuid;

trait FileInterceptor
{
    protected $fileInterceptorConnection = '';

    private $fantasyProperty;
    private $saveLocation;
    private $extension;
    private $lastUuid;
    private $name;


    private function initializeVariable($config)
    {
        $this->fantasyProperty = $config['fantasy_property'];
        $this->saveLocation = FileInterceptorUtil::getSaveLocation($this->model);
        $this->extension = $config['extension'];
        $this->name = $config['name'] ?? null;
    }

    protected function interceptFile()
    {
        $config = config('model_with_file')[get_class($this->model)] ?? null;
        if (empty($config)) {
            return;
        }

        foreach ($config as $item) {
            $this->start($item);
        }
    }

    private function start($config)
    {
        $this->initializeVariable($config);

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
        $file = new File(
            [],
            $this->fileInterceptorConnection
        );

        if (!empty($photo_uuid)) {
            $file = $this->getModelByConnection($photo_uuid);
        }

        $file->file = $this->lastUuid;
        $file->extension = $this->extension;
        $file->reference_id = $this->model->id;
        $file->reference = get_class($this->model);
        $file->name = $this->name;
        $file->save();

    }

    private function deleteFileInDB($photo, $photo_uuid = null): bool
    {
        if ($photo !== 'null') {
            return false;
        }

        $this->getModelByConnection($photo_uuid)->delete();

        return true;
    }

    private function getModelByConnection($photo_uuid)
    {
        $file = null;
        if (!empty($this->fileInterceptorConnection)) {
            return File::on($this->fileInterceptorConnection)
                ->where('uuid', $photo_uuid)
                ->get()
                ->first();
        }

        return File::findByUuid($photo_uuid);
    }

}
