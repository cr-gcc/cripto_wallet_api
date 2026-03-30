<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreRequest;
use App\Services\Portfolio\TransactionService;

class TransactionController extends Controller
{
  protected $transactionService;

  public function __construct(TransactionService $transactionService)
  {
    $this->transactionService = $transactionService;
  }

  public function index()
  {
    $lastTransactions = $this->transactionService->index();
    return response()->json($lastTransactions);
  }

  public function store(StoreRequest $request)
  {
    $transaction = $this->transactionService->store($request);
    return response()->json($transaction);
  }
}
