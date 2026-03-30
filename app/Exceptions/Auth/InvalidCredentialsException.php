<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

class InvalidCredentialsException extends BaseApiException
{
  protected $message = 'Credenciales inválidas';
  protected $errors = [
    'credentials' => ['Credenciales inválidas']
  ];
  protected int $status = 401;
}
