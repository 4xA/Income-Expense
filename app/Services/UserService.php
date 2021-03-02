<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Save or update a user
     * @param array $data data to fill a user
     * @return User created/updated user
     */
    public function saveUserData(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = Str::random(80);

        return $this->userRepository->createOrUpdate($data);
    }
}
