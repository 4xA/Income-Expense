<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = ['status' => 201];

        try {
            $result['data'] = $this->userService->saveUserData($request->all());
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
