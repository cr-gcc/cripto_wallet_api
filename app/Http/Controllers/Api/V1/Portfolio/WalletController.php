<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\StoreRequest;
use App\Services\Portfolio\WalletService;

class WalletController extends Controller
{
  private WalletService $walletService;

  public function __construct(WalletService $walletService)
  {
    $this->walletService = $walletService;
  }

  /**
   * Obtiene todas las wallets del usuario
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $wallets = $this->walletService->index();
    return response()->json($wallets);
  }

  /**
   * Crea una nueva wallet
   * @param StoreRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreRequest $request)
  {
    $wallet = $this->walletService->store($request);
    return response()->json($wallet);
  }

  /**
   * Elimina una wallet
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = $this->walletService->destroy($id);
    return response()->json([
      'message' => $data['message']
    ], $data['status']);
  }
}
