<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

class UserCreationException extends BaseApiException
{
  protected $message = 'Error al crear el usuario';
  protected $errors = [
    'user' => ['Error al crear el usuario']
  ];
  protected int $status = 500;
}
