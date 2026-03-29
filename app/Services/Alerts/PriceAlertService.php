<?php

namespace App\Services\Alerts;

use App\Models\PriceAlert;
use Illuminate\Support\Facades\Auth;

class PriceAlertService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

	public function index()
	{
		return Auth::user()->alerts()->get();
	}

	public function store($request)
	{
		$alert = PriceAlert::create([
			'user_id' => Auth::id(),
			'symbol' => strtolower($request->symbol),
			'condition' => $request->condition,
			'target_price' => $request->target_price
		]);

		return $alert;
	}
}
