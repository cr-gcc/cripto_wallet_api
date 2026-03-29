<?php

namespace App\Http\Controllers\Api\V1\Crypto;

use App\Http\Controllers\Controller;
use App\Services\Crypto\CryptoService;

class CryptoController extends Controller
{
  protected $cryptoService;

  public function __construct(CryptoService $cryptoService)
  {
    $this->cryptoService = $cryptoService;
  }

  /**
   * Obtiene los precios de las criptomonedas a traves del servicio CryptoService
   * @return \Illuminate\Http\JsonResponse
   */
  public function prices()
  {
    $prices = $this->cryptoService->getPrices();
    return response()->json($prices);
  }
}
