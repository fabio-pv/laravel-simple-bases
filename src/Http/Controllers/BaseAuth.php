<?php


namespace LaravelSimpleBases\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Transformers\v1\UserTransformer;
use LaravelSimpleBases\Exceptions\AuthenticationException;
use LaravelSimpleBases\Utils\StatusCodeUtil;

abstract class BaseAuth extends Controller
{
    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if (!$token) {
            throw new AuthenticationException('Invalid credentials');
        }

        return $this->respondWithToken($token);

    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        try {

            $userModel = \Auth::user();
            $data = fractal($userModel, UserTransformer::class);

        } catch (\Exception $e) {
            throw $e;
        }
        return response_default($data, StatusCodeUtil::OK);
    }
}
