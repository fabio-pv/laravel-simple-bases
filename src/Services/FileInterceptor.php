<?php


namespace LaravelSimpleBases\Services;



use Illuminate\Support\Facades\Storage;
use LaravelSimpleBases\Models\File;
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
        if(empty($config)){
            return;
        }
        $this->fantasyProperty = $config['fantasy_property'];
        $this->saveLocation = $config['save_location'];
        $this->extension = $config['extension'];
    }

    protected function interceptFile()
    {

        $this->initializeVariable();

        $photoOrPhotos = $this->lastRealData[$this->fantasyProperty] ?? null;
        if (empty($photoOrPhotos)) {
            return;
        }

        if (is_array($photoOrPhotos)) {
            foreach ($photoOrPhotos as $photo) {
                $this->executeInterceptFile($photo);
            }
            return;
        }

        $this->executeInterceptFile($photoOrPhotos);
        return;

    }

    private function executeInterceptFile($photo)
    {
        $fileName = $this->makeFileName();
        $content = $this->makeContentFile($photo);
        $this->saveFile($fileName, $content);
        $this->saveFileNameInDB();
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

    private function saveFileNameInDB()
    {
        $file = new File();
        $file->file = $this->lastUuid;
        $file->extension = $this->extension;
        $file->reference_id = $this->model->id;
        $file->reference = get_class($this->model);
        $file->save();
    }
}
