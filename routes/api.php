<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Crypto\CryptoController;
use App\Http\Controllers\Api\V1\Wallets\WalletController;
use App\Http\Controllers\Api\V1\Transactions\TransactionController;
use App\Http\Controllers\Api\V1\Alerts\AlertController;
use App\Http\Controllers\Api\V1\Portfolio\PortfolioController;
use App\Http\Controllers\NotificationController;

Route::prefix('v1')->group(function () {
	//	AUTH
	Route::get('/version', [AuthController::class, 'version']);
	Route::prefix('auth')->group(function () {
		Route::post('/register', [AuthController::class, 'register']);
		Route::post('/login', [AuthController::class, 'login']);
	});
	//	CRYPTO
	Route::prefix('crypto')->group(function () {
		Route::get('/prices', [CryptoController::class, 'prices']);
	});

	Route::middleware('auth:api')->group(function () {
		//	AUTH
		Route::prefix('auth')->group(function () {
			Route::get('/me', [AuthController::class, 'me']);
			Route::get('/logout', [AuthController::class, 'logout']);
		});
		//	PORTFOLIO
		Route::prefix('portfolio')->group(function () {
			Route::get('/', [PortfolioController::class, 'index']);
		});
    //	TRANSACTION
		Route::prefix('transactions')->group(function () {
			Route::get('/', [TransactionController::class, 'index']);
			Route::post('/', [TransactionController::class, 'store']);
		});
		//	WALLET
		Route::prefix('wallet')->group(function () {
			Route::get('/', [WalletController::class, 'index']);
			Route::post('/', [WalletController::class, 'store']);
			Route::delete('/{id}', [WalletController::class, 'destroy']);
		});
		//  ALERTS
		Route::prefix('alerts')->group(function () {
			Route::get('/', [AlertController::class, 'index']);
			Route::post('/', [AlertController::class, 'store']);
		});
		//  NOTIFICATIONS
		Route::prefix('notifications')->group(function () {
			Route::get('/', [NotificationController::class, 'index']);
			Route::get('/mark-as-read', [NotificationController::class, 'markAsRead']);
		});
	});
});
