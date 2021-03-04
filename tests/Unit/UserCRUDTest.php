<?php

namespace Tests\Unit;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * User create test
     *
     * @return void
     */
    public function test_user_create(): void
    {
        $user = $this->userService->saveUserData([
            'name' => 'John Doe',
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'Password1234'
        ]);

        $this->assertNotEmpty($user->id);
    }
}
