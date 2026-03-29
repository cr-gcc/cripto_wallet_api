<?php

namespace App\Services\Portfolio;

class TransactionService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }

  public function index()
  {
    $lastTransactions = Auth::user()->transactions()
      ->latest()
      ->get();
    return $lastTransactions;
  }

  public function store($request)
  {
    $symbol = strtolower($request->symbol);

    $transaction = Transaction::create([
      'user_id' => Auth::id(),
      'symbol' => $symbol,
      'type' => $request->type,
      'amount' => $request->amount,
      'price' => $request->price
    ]);

    $wallet = Wallet::firstOrCreate(
      [
        'user_id' => Auth::id(),
        'symbol' => $symbol
      ],
      [
        'amount' => 0
      ]
    );

    if ($request->type === 'buy') {
      $wallet->amount += $request->amount;
    } else {
      $wallet->amount -= $request->amount;
      if ($wallet->amount < 0) {
        return response()->json([
          'error' => 'Insufficient balance'
        ], 400);
      }
    }

    $wallet->save();
    return $transaction;
  }
}
