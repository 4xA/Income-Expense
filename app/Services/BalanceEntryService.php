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
}
