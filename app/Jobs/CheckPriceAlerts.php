<?php

namespace App\Jobs;

use App\Models\PriceAlert;
use App\Services\CryptoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckPriceAlerts implements ShouldQueue
{
	use Queueable;

	/**
	 * Create a new job instance.
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Execute the job.
	 */
	public function handle(CryptoService $cryptoService)
	{
		$alerts = PriceAlert::where('triggered', false)->get();
		$prices = $cryptoService->getPrices();

		foreach ($alerts as $alert) {
			$price = $prices[$alert->symbol]['usd'] ?? 0;
			if (
				($alert->condition === '>' && $price > $alert->target_price) ||
				($alert->condition === '<' && $price < $alert->target_price)
			) {
				$alert->triggered = true;
				$alert->save();
				\Log::info("Envio de notificación alerta de precios");
			}
		}
	}
}
