<?php

namespace App\Http\Controllers\Api\V1\Alerts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PriceAlert\StoreRequest;
use App\Services\Alerts\PriceAlertService;

class PriceAlertController extends Controller
{
	protected $priceAlertService;

	public function __construct(PriceAlertService $priceAlertService)
	{
		$this->priceAlertService = $priceAlertService;
	}

	public function index()
	{
		$alerts = $this->priceAlertService->index();
		return response()->json($alerts);
	}

	public function store(StoreRequest $request)
	{
		$alert = $this->priceAlertService->store($request->validated());
		return response()->json($alert);
	}
}
