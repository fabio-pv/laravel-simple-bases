<?php


namespace LaravelSimpleBases\Http\Controllers;


use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use LaravelSimpleBases\Utils\StatusCodeUtil;

class FileController
{

    public function retrive($path, $photo)
    {
        try {

            $file = Storage::get("photos/${path}/${photo}");
            $response = Response::make($file, StatusCodeUtil::OK);
            $response->header("Content-Type", "image/png");

            return $response;

        } catch (\Exception $e) {
            throw $e;
        }
    }

}
