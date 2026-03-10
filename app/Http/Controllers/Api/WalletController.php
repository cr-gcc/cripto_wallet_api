<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Http\Requests\Wallet\StoreRequest;
use App\Services\PortfolioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WalletController extends Controller
{
	/**
	 * Obtiene todas las wallets del usuario
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request)
	{
		$user = Auth::user();
		$wallets = $user->wallets;
		return response()->json($wallets);
	}

	/**
	 * Crea una nueva wallet
	 * @param StoreRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreRequest $request)
	{
		$user = Auth::user();
		$wallet = new Wallet();
		$wallet->user_id = $user->id;
		$wallet->symbol = strtolower($request->symbol);
		$wallet->amount = $request->amount;
		$wallet->avg_price = $request->avg_price;
		$wallet->save();
		return response()->json($wallet);
	}

	/**
	 * Elimina una wallet
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy($id)
	{
		$data = [];
		$status = 404;
		$user = Auth::user();
		$wallet = Wallet::where('user_id', $user->id)
			->where('id', $id)
			->first();
		if (!$wallet) {
			$data = ['message' => 'Wallet no encontrada'];
		} else {
			$wallet->delete();
			$data = ['message' => 'Wallet eliminada correctamente'];
			$status = 200;
		}
		return response()->json($data, $status);
	}

	/**
	 * Obtiene el portafolio del usuario
	 * @param PortfolioService $portfolioService
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function portfolio(PortfolioService $portfolioService)
	{
		return response()->json($portfolioService->getPortfolio());
	}
}
