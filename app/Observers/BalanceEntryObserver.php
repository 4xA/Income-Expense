<?php

namespace App\Observers;

use App\BalanceEntry;
use App\Services\BalanceService;

class BalanceEntryObserver
{
    protected $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Handle the balance entry "created" event.
     *
     * @param  \App\BalanceEntry  $balanceEntry
     * @return void
     */
    public function created(BalanceEntry $balanceEntry)
    {
        $data = [
            'balance_entry_id' => $balanceEntry->id,
            'user_id' => $balanceEntry->user_id,
            'type' => $balanceEntry->type,
            'balance' => $balanceEntry->balance
        ];

        $this->balanceService->addBalanceEntry($data);
    }

    /**
     * Handle the balance entry "updated" event.
     *
     * @param  \App\BalanceEntry  $balanceEntry
     * @return void
     */
    public function updated(BalanceEntry $balanceEntry)
    {
        // logic is too complicating here so I will leave this un-implemented for now
    }

    /**
     * Handle the balance entry "deleted" event.
     *
     * @param  \App\BalanceEntry  $balanceEntry
     * @return void
     */
    public function deleted(BalanceEntry $balanceEntry)
    {
        $data = [
            'id' => $balanceEntry->id,
            'balance_entry_id' => $balanceEntry->id,
            'user_id' => $balanceEntry->user_id,
            'type' => $balanceEntry->type,
            'balance' => $balanceEntry->balance
        ];

        $this->balanceService->deleteBalance($data);
    }
}
