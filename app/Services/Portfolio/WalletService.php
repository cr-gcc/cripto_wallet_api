<?php

namespace App\Services\Portfolio;

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletService
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
    $user = Auth::user();
    $wallets = $user->wallets;
    return $wallets;
  }

  public function store(array $data)
  {
    $user = Auth::user();
    $wallet = new Wallet();
    $wallet->user_id = $user->id;
    $wallet->symbol = strtolower($data['symbol']);
    $wallet->amount = $data['amount'];
    $wallet->avg_price = $data['avg_price'];
    $wallet->save();
    return $wallet;
  }

  public function destroy($id)
  {
    $user = Auth::user();
    $wallet = Wallet::where('user_id', $user->id)
      ->where('id', $id)
      ->first();
    if (!$wallet) {
      throw new \Exception('Wallet not found');
    } else {
      $wallet->delete();
    }
    return $wallet;
  }
}
