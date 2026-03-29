<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function __construct(private AuthService $authService) {}

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
  public function me()
  {
    return $this->authService->me();
  }

  /**
   * Registra un nuevo usuario
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function register(RegisterRequest $request)
  {
    return $this->authService->register($request);
  }

  /**
   * Inicia sesión
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(LoginRequest $request)
  {
    return $this->authService->login($request);
  }

  /**
   * Cierra sesión
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    return $this->authService->logout();
  }
}
