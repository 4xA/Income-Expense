<?php

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * Login test
     *
     * @return void
     */
    public function test_login(): void
    {
        $user = $this->userService->saveUserData([
            'name' => 'John Doe',
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'Password1234'
        ]);

        $apiToken = $this->userService->getApiToken([
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'Password1234'
        ]);

        $this->assertEquals($user->api_token, $apiToken);

        $this->expectException(InvalidArgumentException::class);

        $apiToken = $this->userService->getApiToken([
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'wrongpassword'
        ]);

        $apiToken = $this->userService->getApiToken([
            'password' => 'wrongpassword'
        ]);
    }
}
