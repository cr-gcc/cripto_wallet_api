<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PriceAlert;
use App\Http\Requests\PriceAlert\StoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AlertController extends Controller
{

	public function index()
	{
		return Auth::user()->alerts()->get();
	}

	public function store(StoreRequest $request)
	{
		$alert = PriceAlert::create([
			'user_id' => Auth::id(),
			'symbol' => strtolower($request->symbol),
			'condition' => $request->condition,
			'target_price' => $request->target_price
		]);

		return response()->json($alert);
	}
}
