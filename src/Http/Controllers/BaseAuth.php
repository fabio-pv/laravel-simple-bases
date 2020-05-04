<?php


namespace LaravelSimpleBases\Http\Controllers;


use App\Http\Controllers\Controller;
use LaravelSimpleBases\Exceptions\AuthenticationException;

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

    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
