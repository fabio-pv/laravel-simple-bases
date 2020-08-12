<?php


namespace LaravelSimpleBases\Http\Controllers;


use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use LaravelSimpleBases\Utils\StatusCodeUtil;

/**
 * @group File
 * @package LaravelSimpleBases\Http\Controllers
 */
class FileController
{

    /**
     * File
     *
     * @urlParam path required
     * @urlParam uuid required
     *
     * @param $path
     * @param $photo
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
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
