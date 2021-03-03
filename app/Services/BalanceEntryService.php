<?php

namespace App\Services;

use App\Income;
use App\Repositories\Eloquent\IncomeRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class BalanceEntryService
{
    /**
     * BalanceEntry repository
     * 
     * @var \App\Repositories\Eloquent\BalanceEntryRepository
     */
    protected $incomeRepository;

    public function __construct(IncomeRepository $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * Save a new income entry
     * 
     * @throws InvalidArgumentExcpetion if data is not valid
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

        $data['user_id'] = auth()->user()->id;

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

    public function getPaginated(array $data)
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
}
