<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\WalletController;

Route::get('/version', [AuthController::class, 'version']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
	//	AUTH
  Route::get('/me', [AuthController::class, 'me']);
  Route::post('/logout', [AuthController::class, 'logout']);
	//	MARKET
	Route::get('/market/prices', [MarketController::class, 'getPrices']);
	//	WALLET
	Route::get('/wallet', [WalletController::class, 'index']);
	Route::post('/wallet', [WalletController::class, 'store']);
  Route::delete('/wallet/{id}', [WalletController::class, 'destroy']);
	//	
});
