<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Crypto\CryptoService;

class CryptoServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    $this->app->singleton(CryptoService::class, function ($app) {
      return new CryptoService(
        config('services.coingecko.base_url')
      );
    });
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    //
  }
}
