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

	public function store(array $data)
	{
		$alert = PriceAlert::create([
			'user_id' => Auth::id(),
			'symbol' => strtolower($data['symbol']),
			'condition' => $data['condition'],
			'target_price' => $data['target_price']
		]);

		return $alert;
	}
}
