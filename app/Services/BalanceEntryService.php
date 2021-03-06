<?php

namespace App\Services;

use App\Expense;
use App\Income;
use App\Repositories\ExpenseRepositoryInterface;
use App\Repositories\IncomeRepositoryInterface;
use App\Traits\UserQueriable;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class BalanceEntryService
{
    use UserQueriable;

    /**
     * BalanceEntry repository
     * 
     * @var \App\Repositories\Eloquent\IncomeRepository
     */
    protected $incomeRepository;

    /**
     * BalanceEntry repository
     * 
     * @var \App\Repositories\Eloquent\ExpenseRepository
     */
    protected $expenseRepository;

    public function __construct(IncomeRepositoryInterface $incomeRepository, ExpenseRepositoryInterface $expenseRepository)
    {
        $this->incomeRepository = $incomeRepository;
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Save a new income entry
     * 
     * @throws InvalidArgumentExcpetion if data is not valid
     * 
     * @throws AuthenticationExcpetion if user is not logged in
     * 
     * @param array $data data to fill a user
     * 
     * @return \App\Income
     */
    public function saveIncome(array $data): Income
    {
        $validator = Validator::make($data, [
            'balance' => 'required|numeric|min:0|max:9999999.999',
            'title' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['user_id'] = $this->getUserId();

        return $this->incomeRepository->createOrUpdate($data);
    }

    /**
     * Retrieve income by id
     * 
     * @param int $id id of income
     * 
     * @return ?\App\Income
     */
    public function getIncomeById(int $id): ?Income
    {
        return $this->incomeRepository->getById($id);
    }

    /**
     * Update income by id
     * 
     * @param array $data data to update income
     * 
     * @param int $id id of income
     * 
     * @return ?\App\Income
     */
    public function updateIncomeById(array $data, int $id): ?Income
    {
        $data['id'] = $id;

        $validator = Validator::make($data, [
            'id' => 'required|exists:balance_entries',
            'balance' => 'nullable|numeric|min:0|max:9999999.999',
            'title' => 'nullable|string',
            'description' => 'nullable|string'
        ]);       

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['user_id'] = auth()->user()->id;

        return $this->incomeRepository->createOrUpdate($data, $id);
    }

    /**
     * Delete income by id
     * 
     * @param int $id id of resource
     * 
     * @return bool is resource deleted or not found
     */
    public function deleteIncomeById(int $id): bool
    {
        return $this->incomeRepository->delete($id);
    }

    /**
     * Paginated income
     * 
     * @param array $data filters for pagination
     */
    public function getPaginatedIncome(array $data)
    {
        $validator = Validator::make($data, [
            'per_page' => 'integer|nullable'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['per_page'] = array_key_exists('per_page', $data) && !is_null($data['per_page']) ? $data['per_page'] : 10;

        $result = $this->incomeRepository->paginate($data);

        return $result;
    }

    /**
     * Save a new expense entry
     * 
     * @throws InvalidArgumentExcpetion if data is not valid
     * 
     * @throws AuthenticationExcpetion if user is not logged in
     * 
     * @param array $data data to fill a user
     * 
     * @return \App\Expense
     */
    public function saveExpense(array $data): Expense
    {
        $validator = Validator::make($data, [
            'balance' => 'required|numeric|min:0|max:9999999.999',
            'title' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['user_id'] = $this->getUserId();

        return $this->expenseRepository->createOrUpdate($data);
    }

    /**
     * Retrieve expense by id
     * 
     * @param int $id id of income
     * 
     * @return ?\App\Expense
     */
    public function getExpenseById(int $id): ?Expense
    {
        return $this->expenseRepository->getById($id);
    }

    /**
     * Update expense by id
     * 
     * @param array $data data to update expense
     * 
     * @param int $id id of expense
     * 
     * @return ?\App\Expense
     */
    public function updateExpenseById(array $data, int $id): ?Expense
    {
        $data['id'] = $id;

        $validator = Validator::make($data, [
            'id' => 'required|exists:balance_entries',
            'balance' => 'nullable|numeric|min:0|max:9999999.999',
            'title' => 'nullable|string',
            'description' => 'nullable|string'
        ]);       

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['user_id'] = $this->getUserId();

        return $this->expenseRepository->createOrUpdate($data, $id);
    }

    /**
     * Delete expense by id
     * 
     * @param int $id id of resource
     * 
     * @return bool is resource deleted or not found
     */
    public function deleteExpenseById(int $id): bool
    {
        return $this->expenseRepository->delete($id);
    }

    /**
     * Paginated expense
     * 
     * @param array $data filters for pagination
     */
    public function getPaginatedExpense(array $data)
    {
        $validator = Validator::make($data, [
            'per_page' => 'integer|nullable'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['per_page'] = array_key_exists('per_page', $data) && !is_null($data['per_page']) ? $data['per_page'] : 10;

        $result = $this->expenseRepository->paginate($data);

        return $result;
    }

    /**
     * Calcualte balance
     * 
     * @return float balance
     */
    public function calculateBalance(): float
    {
        $balance = 0.0;

        $this->incomeRepository->chunk(100, function ($incomes) use (&$balance) {
            foreach ($incomes as $income) {
                $balance += $income->balance;
            }
        });

        $this->expenseRepository->chunk(100, function ($expenses) use (&$balance) {
            foreach ($expenses as $expense) {
                $balance -= $expense->balance;
            }
        });

        return round($balance, 3);
    }
}
