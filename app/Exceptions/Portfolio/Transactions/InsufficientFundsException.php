<?php

namespace App\Exceptions\Portfolio\Transactions;

use App\Exceptions\BaseApiException;

class InsufficientFundsException extends BaseApiException
{
  protected $message = 'Fondos insuficientes';
  protected $errors = [
    'transaction' => ['Fondos insuficientes para realizar la transacción.']
  ];
  protected int $status = 400;
}
