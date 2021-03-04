<?php

namespace Tests\Unit;

use App\Expense;
use App\Services\BalanceEntryService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $balanceEntryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balanceEntryService = $this->app->make(BalanceEntryService::class);
    }

    /**
     * Test create expense
     * 
     * @return void
     */
    public function test_expense_create(): void
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $expense = $this->balanceEntryService->saveExpense([
            'balance' => 99.123,
            'title' => 'expense',
            'description' => 'expense description'
        ]);

        $this->assertNotEmpty($expense->id);
        $this->assertEquals(99.123, $expense->balance);
        $this->assertEquals(Expense::class, get_class($expense));
    }

    /**
     * Test retrieve expense
     * 
     * @return void
     */
    public function test_retrieve_expense(): void
    {
        factory(User::class)->create();

        $expense = factory(Expense::class)->create();

        $retrievedExpense = $this->balanceEntryService->getExpenseById($expense->id);

        $this->assertEquals($expense->id, $retrievedExpense->id);
        $this->assertEquals(Expense::class, get_class($expense));
    }

    /**
     * Test update expense
     * 
     * @return void
     */
    public function test_update_expense(): void
    {
        $user = factory(User::class)->create();

        $this->be($user);

        $expense = factory(Expense::class)->create();

        $expense = $this->balanceEntryService->updateExpenseById([
            'balance' => 100
        ], $expense->id);

        $this->assertEquals(100, $expense->balance);
        $this->assertEquals(Expense::class, get_class($expense));
    }

    /**
     * Test delete expense
     * 
     * @return void
     */
    public function test_delete_expense()
    {
        factory(User::class)->create();

        $expense = factory(Expense::class)->create();

        $this->balanceEntryService->deleteExpenseById($expense->id);

        $this->assertNull(Expense::find($expense->id));
    }
}