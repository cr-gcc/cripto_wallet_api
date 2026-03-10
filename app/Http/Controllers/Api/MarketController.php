<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CryptoService;
use Illuminate\Http\Request;

class MarketController extends Controller
{
	protected $cryptoService;

	/**
	 * @param CryptoService $cryptoService
	 */
	public function __construct(CryptoService $cryptoService)
	{
		$this->cryptoService = $cryptoService;
	}

	/**
	 * Obtiene los precios de las criptomonedas a traves del servicio CryptoService
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPrices()
	{
		$prices = $this->cryptoService->getPrices();
		return response()->json($prices);
	}
}
