<?php

namespace App\Jobs;

use App\Models\PriceAlert;
use App\Services\CryptoService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

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
		//	Alertas controladas por el usuario
		//$alerts = PriceAlert::where('triggered', false)->get();
		$alerts = PriceAlert::all();
		$prices = $cryptoService->getPrices();
		foreach ($alerts as $alert) {
			$price = $prices[$alert->symbol]['usd'] ?? 0;
			if ($alert->condition === '>' && $price > $alert->target_price) {
				/*
				$alert->triggered = true;
				$alert->save();
				*/
				Log::info("SUBIDA DE PRECIO - " . Carbon::now()->format('Y-m-d H:i:s'));
				Log::info("|------------------------------------------------------------|");
				Log::info("Precio: " . $price);
				Log::info("Target: " . $alert->target_price);
				Log::info("Condition: " . $alert->condition);
				Log::info("El precio de " . $alert->symbol . " ha subido a " . $price . " y es mayor a " . $alert->target_price);
				Log::info("|------------------------------------------------------------|");
				Log::info("\n");
			} else if ($alert->condition === '<' && $price < $alert->target_price) {
				/*
				$alert->triggered = true;
				$alert->save();
				*/
				Log::info("BAJADA DE PRECIO - " . Carbon::now()->format('Y-m-d H:i:s'));
				Log::info("|------------------------------------------------------------|");
				Log::info("Precio: " . $price);
				Log::info("Target: " . $alert->target_price);
				Log::info("Condition: " . $alert->condition);
				Log::info("El precio de " . $alert->symbol . " ha bajado a " . $price . " y es menor a " . $alert->target_price);
				Log::info("|------------------------------------------------------------|");
				Log::info("\n");
			} else {
				Log::info("PRECIO ESTABLE - " . Carbon::now()->format('Y-m-d H:i:s'));
				Log::info("|------------------------------------------------------------|");
				Log::info("Precio: " . $price);
				Log::info("Target: " . $alert->target_price);
				Log::info("Condition: " . $alert->condition);
				Log::info("El precio de " . $alert->symbol . " se mantiene en " . $price);
				Log::info("|------------------------------------------------------------|");
				Log::info("\n");
			}
		}
	}
}
