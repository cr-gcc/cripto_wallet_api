<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CryptoService
{
	public function getPrices(): array
	{
		// Cache for 60 seconds
		return Cache::remember('crypto_prices', 60, function () {
			try {
				$response = Http::timeout(10)->get(
					'https://api.coingecko.com/api/v3/simple/price',
					[
						'ids'           => 'bitcoin,ethereum,solana',
						'vs_currencies' => 'usd',
					]
				);
				if ($response->successful()) {
					return $response->json();
				}
				Log::warning('CoinGecko API returned non-200 status: ' . $response->status());
				return [];
			} catch (\Exception $e) {
				Log::error('CoinGecko API error: ' . $e->getMessage());
				return [];
			}
		});
	}
}
