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

  public function store(array $data)
  {
    $symbol = strtolower($data['symbol']);

    $transaction = Transaction::create([
      'user_id' => Auth::id(),
      'symbol' => $symbol,
      'type' => $data['type'],
      'amount' => $data['amount'],
      'price' => $data['price']
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

    if ($data['type'] === 'buy') {
      $wallet->amount += $data['amount'];
    } else {
      $wallet->amount -= $data['amount'];
      if ($wallet->amount < 0) {
        throw new \Exception('Insufficient balance');
      }
    }
    $wallet->save();

    return $transaction;
  }
}
