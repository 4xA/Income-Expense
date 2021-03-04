<?php

namespace App\Http\Controllers;

use App\Services\BalanceEntryService;
use Exception;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * Service layer for BalanceEntry
     * 
     * @var \App\Services\BalanceEntryService
     */
    protected $balanceEntryService;

    public function __construct(BalanceEntryService $balanceEntryService)
    {
        $this->balanceEntryService = $balanceEntryService;
    }
    
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $result['status'] = '200';

        try {
            $result['data'] = [
                'balance' => $this->balanceEntryService->calculateBalance()
            ];
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
