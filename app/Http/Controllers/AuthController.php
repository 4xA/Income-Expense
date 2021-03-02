<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * User Service
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Login to service using creds
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = [
                'api_token' => $this->userService->getApiToken($request->all())
            ];
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
