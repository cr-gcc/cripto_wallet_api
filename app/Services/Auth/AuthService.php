<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Auth\UserCreationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    return Auth::user();
  }

  public function register(array $data)
  {
    $data['password'] = Hash::make($data['password']);
    $user = User::create($data);
    if (!$user) {
      throw new UserCreationException();
    }
    return $user;
  }

  public function login(array $data)
  {
    $email = $data['email'];
    $password = $data['password'];
    if (!Auth::attempt(['email' => $email, 'password' => $password])) {
      throw new InvalidCredentialsException();
    }
    $user = Auth::user();
    $token = $user->createToken('authToken')->accessToken;
    $data = [
      'user' => $user,
      'token' => $token,
    ];
    return $data;
  }

  public function logout()
  {
    Auth::user()->token()->revoke();
    $data = [
      'message' => 'Successfully logged out',
    ];
    return $data;
  }
}
