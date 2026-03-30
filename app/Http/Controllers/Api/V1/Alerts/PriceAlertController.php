<?php

namespace App\Http\Controllers\Api\V1\Alerts;

use App\Http\Controllers\Controller;
use App\Models\PriceAlert;
use App\Http\Requests\Alerts\Price\StoreRequest;
use App\Http\Requests\Alerts\Price\UpdateRequest;
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

  public function update(PriceAlert $alert, UpdateRequest $request)
  {
    $alert = $this->priceAlertService->update($alert->id, $request->validated());
    return response()->json($alert);
  }

  public function destroy(PriceAlert $alert)
  {
    $alert = $this->priceAlertService->destroy($alert->id);
    return response()->json($alert);
  }
}
