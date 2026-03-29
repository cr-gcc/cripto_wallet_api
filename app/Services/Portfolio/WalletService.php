<?php

namespace App\Services\Portfolio;

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

  public function store(StoreRequest $request)
  {
    $user = Auth::user();
    $wallet = new Wallet();
    $wallet->user_id = $user->id;
    $wallet->symbol = strtolower($request->symbol);
    $wallet->amount = $request->amount;
    $wallet->avg_price = $request->avg_price;
    $wallet->save();
    return $wallet;
  }

  public function destroy($id)
  {
    $message = '';
    $status = 404;
    $user = Auth::user();
    $wallet = Wallet::where('user_id', $user->id)
      ->where('id', $id)
      ->first();
    if (!$wallet) {
      $message = 'Wallet no encontrada';
    } else {
      $wallet->delete();
      $message = 'Wallet eliminada correctamente';
      $status = 200;
    }
    $data = [
      'message' => $message,
      'status' => $status
    ];
    return $data;
  }
}
