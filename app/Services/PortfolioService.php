<?php

namespace App\Services;

use App\Models\Wallet;
use App\Services\CryptoService;
use Illuminate\Support\Facades\Auth;

class PortfolioService
{
	protected $cryptoService;

	public function __construct(CryptoService $cryptoService)
	{
		$this->cryptoService = $cryptoService;
	}

	public function getPortfolio()
	{
		$assets = [];
		$total = 0;

		$wallets = Wallet::where('user_id', Auth::id())->get();
		$prices = $this->cryptoService->getPrices();

		foreach ($wallets as $wallet) {
			$symbol = strtolower($wallet->symbol);
			$price = $prices[$symbol]['usd'] ?? 0;
			$value = $wallet->amount * $price;
			$assets[] = [
				'symbol' => $symbol,
				'amount' => $wallet->amount,
				'price' => $price,
				'value' => $value
			];
			$total += $value;
		}

		return [
			'total_value_usd' => $total,
			'assets' => $assets
		];
	}
}
