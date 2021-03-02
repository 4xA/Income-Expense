<?php

use App\Repositories\Eloquent\UserRepository;
use App\Services\UserService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Login test
     *
     * @return void
     */
    public function test_login(): void
    {
        $userService = new UserService(new UserRepository(new User()));

        $user = $userService->saveUserData([
            'name' => 'John Doe',
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'Password1234'
        ]);

        $apiToken = $userService->getApiToken([
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'Password1234'
        ]);

        $this->assertEquals($user->api_token, $apiToken);

        $this->expectException(InvalidArgumentException::class);

        $apiToken = $userService->getApiToken([
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'wrongpassword'
        ]);

        $apiToken = $userService->getApiToken([
            'password' => 'wrongpassword'
        ]);
    }
}
