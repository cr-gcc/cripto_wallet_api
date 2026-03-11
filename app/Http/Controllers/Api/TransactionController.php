<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Http\Requests\Transaction\StoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
	public function index()
	{
		return Auth::user()->transactions()
			->latest()
			->get();
	}

	public function store(StoreRequest $request)
	{
		$symbol = strtolower($request->symbol);

		$transaction = Transaction::create([
			'user_id' => Auth::id(),
			'symbol' => $symbol,
			'type' => $request->type,
			'amount' => $request->amount,
			'price' => $request->price
		]);

		$wallet = Wallet::firstOrCreate(
			[
				'user_id' => Auth::id(),
				'symbol' => $symbol
			],
			[
				'amount' => 0
			]
		);

		if ($request->type === 'buy') {
			$wallet->amount += $request->amount;
		} else {
			$wallet->amount -= $request->amount;
			if ($wallet->amount < 0) {
				return response()->json([
					'error' => 'Insufficient balance'
				], 400);
			}
		}

		$wallet->save();
		return response()->json($transaction);
	}
}
