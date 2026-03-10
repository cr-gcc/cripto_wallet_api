<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\StoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WalletController extends Controller
{
		public function index()
		{
			$user = Auth::user();
			$wallets = $user->wallets;
			return response()->json($wallets);
		}

		public function store (StoreRequest $request) {
			$user = Auth::user();
			$wallet = new Wallet();
			$wallet->user_id = $user->id;
			$wallet->symbol = strtolower($request->symbol);
			$wallet->amount = $request->amount;
			$wallet->avg_price = $request->avg_price;
			$wallet->save();
			return response()->json($wallet);
		}
		
		public function destroy ($id) {
			$data = [];
			$status = 404;
			$user = Auth::user();
			$wallet = Wallet::where('user_id', $user->id)
				->where('id', $id)
				->first();
			if (!$wallet) {
				$data = ['message' => 'Wallet no encontrada'];
			}
			else {
				$wallet->delete();
				$data = ['message' => 'Wallet eliminada correctamente'];	
				$status = 200;
			}
			return response()->json($data, $status);
		}
}
