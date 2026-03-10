<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CryptoService
{
		public function getPrices()
		{
			// Cache for 60 seconds
			return Cache::remember('crypto_prices', 60, function () {
				$response = Http::get(
						'https://api.coingecko.com/api/v3/simple/price',
						[
								'ids' => 'bitcoin,ethereum,solana',
								'vs_currencies' => 'usd'
						]
				);
				//
				return $response->json();
			});
		}
}
