<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }

  public function me()
  {
    $user = Auth::user();
    return $user;
  }

  public function register()
  {
    $user = Auth::user();
    return $user;
  }

  public function login($request)
  {
    if (!Auth::attempt($request->only('email', 'password'))) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }
    $user = Auth::user();
    $token = $user->createToken('authToken')->accessToken;
    $data = [
      'token' => $token,
      'user' => $user
    ];
    return $data;
  }

  public function logout()
  {
    Auth::user()->token()->revoke();
    $data = [
      'message' => 'Logout successful'
    ];
    return $data;
  }
}
