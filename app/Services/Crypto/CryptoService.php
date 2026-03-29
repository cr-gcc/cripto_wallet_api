<?php

namespace App\Services\Crypto;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CryptoService
{
  private string $baseUrl;

  /**
   * Create a new class instance.
   */
  public function __construct(string $baseUrl)
  {
    $this->baseUrl = $baseUrl;
  }

  public function getPrices(): array
  {
    $url = $this->baseUrl . '/simple/price';
    $params = [
      'ids'           => 'bitcoin,ethereum,solana',
      'vs_currencies' => 'usd',
    ];
    // Cache for 60 seconds
    return Cache::remember('crypto_prices', 60, function () use ($url, $params) {
      try {
        $response = Http::timeout(10)->get($url, $params);
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
