<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
  protected $authService;

  public function __construct(AuthService $authService)
  {
    $this->authService = $authService;
  }

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
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {
    return $this->authService->me();
  }

  /**
   * Registra un nuevo usuario
   * @param RegisterRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function register(RegisterRequest $request)
  {
    $data = $this->authService->register($request->validated());
    return response()->json($data, 201);
  }

  /**
   * Inicia sesión
   * @param LoginRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(LoginRequest $request)
  {
    $data = $this->authService->login($request->validated());
    return response()->json($data);
  }

  /**
   * Cierra sesión
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    return $this->authService->logout();
  }
}
