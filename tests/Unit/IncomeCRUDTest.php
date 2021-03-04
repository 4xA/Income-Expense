<?php

namespace Tests\Unit;

use App\Income;
use App\Services\BalanceEntryService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncomeCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $balanceEntryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balanceEntryService = $this->app->make(BalanceEntryService::class);
    }

    /**
     * Test create income
     * 
     * @return void
     */
    public function test_income_create(): void
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $income = $this->balanceEntryService->saveIncome([
            'balance' => 99.123,
            'title' => 'income',
            'description' => 'income description'
        ]);

        $this->assertNotEmpty($income->id);
        $this->assertEquals(99.123, $income->balance);
    }

    /**
     * Test retrieve income
     * 
     * @return void
     */
    public function test_retrieve_income(): void
    {
        factory(User::class)->create();

        $income = factory(Income::class)->create();

        $retrievedIncome = $this->balanceEntryService->getIncomeById($income->id);

        $this->assertEquals($income->id, $retrievedIncome->id);
    }

    /**
     * Test update income
     * 
     * @return void
     */
    public function test_update_income(): void
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $income = factory(Income::class)->create();

        $income = $this->balanceEntryService->updateIncomeById([
            'balance' => 100
        ], $income->id);

        $this->assertEquals(100, $income->balance);
    }

    /**
     * Test delete income
     * 
     * @return void
     */
    public function test_delete_income()
    {
        factory(User::class)->create();

        $income = factory(Income::class)->create();

        $this->balanceEntryService->deleteIncomeById($income->id);

        $this->assertNull(Income::find($income->id));
    }
}