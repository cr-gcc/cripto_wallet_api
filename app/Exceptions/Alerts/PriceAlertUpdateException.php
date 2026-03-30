<?php

namespace App\Exceptions\Alerts;

use App\Exceptions\BaseApiException;

class PriceAlertUpdateException extends BaseApiException
{
  protected $message = 'Error al actualizar la alerta de precio';
  protected $errors = [
    'alert' => ['Error al actualizar la alerta de precio. Intente nuevamente.']
  ];
  protected int $status = 500;
}
