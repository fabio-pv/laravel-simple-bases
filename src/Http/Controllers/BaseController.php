<?php


namespace LaravelSimpleBases\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Validations\BaseValidation;
use App\Services\v1\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelSimpleBases\Utils\StatusCodeUtil;

abstract class BaseController extends Controller
{

    use HTTPQuery;

    protected $model;
    /**
     * @var BaseService
     */
    protected $service;
    protected $transformer;
    /**
     * @var BaseValidation
     */
    protected $validation;

    /**
     * @var Model
     */
    private $retrive;


    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index()
    {
        try {

            $this->retrive = $this->service->retriveAll();
            $this->filter();
            $this->order();
            $this->paginate();
            $response = fractal($this->retrive, $this->transformer);

        } catch (\Exception $e) {
            throw $e;
        }

        return response_default($response, StatusCodeUtil::OK);

    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function show($uuid)
    {
        try {

            $this->retrive = $this->service->searchByUuid($uuid);
            $response = fractal($this->retrive, $this->transformer);

        } catch (\Exception $e) {
            throw $e;
        }

        return response_default($response, StatusCodeUtil::OK);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try {

            $this->validation->validate($request, __FUNCTION__);

            $data = $request->all();
            $this->retrive = $this->service->save($data);

            $response = fractal($this->retrive, $this->transformer);

        } catch (\Exception $e) {
            throw $e;
        }

        return response_default($response, StatusCodeUtil::CREATED);

    }

    /**
     * @param Request $request
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, $uuid)
    {
        try {

            $this->validation->validate($request, __FUNCTION__);

            $data = $request->all();
            $this->retrive = $this->service->change($data, $uuid);

            $response = fractal($this->retrive, $this->transformer);

        } catch (\Exception $e) {
            throw $e;
        }

        return response_default($response, StatusCodeUtil::CREATED);

    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($uuid)
    {

        try {

            $this->retrive = $this->service->remove($uuid);

            $response = fractal($this->retrive, $this->transformer);

        } catch (\Exception $e) {
            throw $e;
        }

        return response_default($response, StatusCodeUtil::CREATED);

    }

}
