<?php

namespace App\Services\Alerts;

use App\Models\PriceAlert;
use App\Exceptions\Alerts\PriceAlertCreationException;
use App\Exceptions\Alerts\PriceAlertUpdateException;
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
		try {
			$alert = PriceAlert::create([
				'user_id' => Auth::id(),
				'symbol' => strtolower($data['symbol']),
				'condition' => $data['condition'],
				'target_price' => $data['target_price']
			]);
		} catch (\Exception $e) {
			throw new PriceAlertCreationException();
		}

    return $alert;
	}

  public function update(int $id, array $data)
  {
    try {
      $alert = PriceAlert::where('user_id', Auth::id())->find($id);
      $data['triggered'] = false;
      $alert->update($data);
    } catch (\Exception $e) {
      throw new PriceAlertUpdateException();
    }
    return $alert;
  }

  public function destroy(int $id)
  {
    $alert = PriceAlert::where('user_id', Auth::id())->find($id);
    $alert->delete();
    return $alert;
  }
}
