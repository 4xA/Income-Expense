<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Services\BalanceEntryService;
use Exception;
use Illuminate\Http\Request;

class ExpenseController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->only(['per_page']);

        $result = ['status' => 200];

        try {
            $result = $this->balanceEntryService->getPaginatedExpense($data);
            $result['status'] = 200;
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = ['status' => '201'];

        try {
            $result['data'] = $this->balanceEntryService->saveExpense($request->all());
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $result = ['status' => '200'];

        try {
            $data = $this->balanceEntryService->getExpenseById($id);

            if (is_null($data)) {
                $result['status'] = '404';
            }

            $result['data'] = $data;
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $result = ['status' => '200'];

        try {
            $data = $this->balanceEntryService->updateExpenseById($request->all(), $id);

            if (is_null($data)) {
                $result['status'] = '404';
            }

            $result['data'] = $data;
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = ['status' => '204'];

        try {
            if (!$this->balanceEntryService->deleteExpenseById($id)) {
                $result = [
                    'status' => 404,
                    'error' => 'resource not found'
                ];
            }
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
