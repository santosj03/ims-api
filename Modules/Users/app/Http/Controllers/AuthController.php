<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Users\Services\AuthService;
use Modules\Users\Http\Requests\LoginRequest;
use Modules\Users\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $service)
    {
        $this->authService = $service;
    }

    public function register(RegisterRequest $request)
    {
        try{
            return $this->authService->register($request->payload());
        }catch(\Exception $ex){
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }

    public function authenticate(LoginRequest $request)
    {
        return $this->authService->login($request->payload());
    }
}
