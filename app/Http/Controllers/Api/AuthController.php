<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	/**
	 * Obtiene la versión de la API
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function version()
	{
		return response()->json([
			'app' => 'Cripto Wallet API',
			'version' => '0.0.1'
		]);
	}

	/**
	 * Obtiene el usuario autenticado
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function me(Request $request)
	{
		return response()->json($request->user());
	}

	/**
	 * Inicia sesión
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request)
	{
		if (!Auth::attempt($request->only('email', 'password'))) {
			return response()->json(['error' => 'Unauthorized'], 401);
		}

		$user = Auth::user();

		$token = $user->createToken('authToken')->accessToken;

		return response()->json([
			'token' => $token,
			'user' => $user
		]);
	}

	/**
	 * Cierra sesión
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout(Request $request)
	{
		$request->user()->token()->revoke();

		return response()->json([
			'message' => 'Logout successful'
		]);
	}
}
