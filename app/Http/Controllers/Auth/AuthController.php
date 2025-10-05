<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService) 
    {
        $this->authService = $authService;
    }
    
    /**
     * User Login
     * 
     * @group Auth
     * @unauthenticated
     * @param LoginRequest $requst
     * @return JsonResponse
     */
    public function login (LoginRequest $requst): JsonResponse
    { 
        $request = $requst->validated();
        $response = $this->authService->login($request);
        return $this->response('success', [
            'user' => UserResource::make($response['user']),
            'token' => $response['token']
        ], Response::HTTP_OK);
    }

    /**
     * User Logout
     * 
     * @group Auth
     * @authenticated
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return $this->response('success', [], Response::HTTP_OK);
    }
}
