<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\UserRepository;
use App\Services\UserService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User create test
     *
     * @return void
     */
    public function test_user_create(): void
    {
        $userService = new UserService(new UserRepository(new User()));

        $user = $userService->saveUserData([
            'name' => 'John Doe',
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'Password1234'
        ]);

        $this->assertNotEmpty($user->id);
    }
}
