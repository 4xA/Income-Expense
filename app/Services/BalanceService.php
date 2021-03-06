<?php

namespace App\Services;

use App\Balance;
use App\Repositories\BalanceRepositoryInterface;
use InvalidArgumentException;

class BalanceService
{
    /**
     * Balance repository
     * 
     * @var \App\Repositories\Eloquent\BalanceRepository
     */
    protected $balanceRepository;

    public function __construct(BalanceRepositoryInterface $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function addBalanceEntry(array $data): void
    {
        $latestBalance = $this->getLatest($data['user_id']);

        $balance = 0.0;

        // typicall I would use an enum here but I am simplifying
        switch ($data['type']) {
            case 'income':
                $balance = ($latestBalance->balance ?? 0) + $data['balance'];
                break;
            case 'expense':
                $balance = ($latestBalance->balance ?? 0) - $data['balance'];
                break;
            default:
                throw new InvalidArgumentException();
                break;
        }

        $data['balance'] = round($balance, 3);

        $this->balanceRepository->createOrUpdate($data);
    } 

    public function getLatest(int $userId): Balance
    {
        return $this->balanceRepository->lastWhere('user_id', $userId) ?? new Balance();
    }

    public function deleteBalance(array $data): bool
    {
        $latestBalance = $this->getLatest($data['user_id']);

        $balance = 0.0;

        // typicall I would use an enum here but I am simplifying
        switch ($data['type']) {
            case 'income':
                $balance = ($latestBalance->balance ?? 0) - $data['balance'];
                break;
            case 'expense':
                $balance = ($latestBalance->balance ?? 0) + $data['balance'];
                break;
            default:
                throw new InvalidArgumentException();
                break;
        }

        $data['balance'] = round($balance, 3);

        $this->balanceRepository->createOrUpdate(
            ['balance' => $data['balance']],
            $latestBalance->id
        );

        return $this->balanceRepository->delete($data['id']);
    }
}
