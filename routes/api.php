<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\AlertController;

//	AUTH
Route::get('/version', [AuthController::class, 'version']);
Route::post('/login', [AuthController::class, 'login']);
//	MARKET
Route::get('/market/prices', [MarketController::class, 'getPrices']);

Route::middleware('auth:api')->group(function () {
	//	AUTH
	Route::get('/me', [AuthController::class, 'me']);
	Route::post('/logout', [AuthController::class, 'logout']);
	//	WALLET
	Route::get('/wallet', [WalletController::class, 'index']);
	Route::post('/wallet', [WalletController::class, 'store']);
	Route::delete('/wallet/{id}', [WalletController::class, 'destroy']);
	Route::get('/wallet/portfolio', [WalletController::class, 'portfolio']);
	//	TRANSACTION
	Route::get('/transactions', [TransactionController::class, 'index']);
	Route::post('/transactions', [TransactionController::class, 'store']);
	//  ALERTS
	Route::get('/alerts', [AlertController::class, 'index']);
	Route::post('/alerts', [AlertController::class, 'store']);
});
