<?php

namespace App\Exceptions\Alerts;

use App\Exceptions\BaseApiException;

class PriceAlertCreationException extends BaseApiException
{
    protected $message = 'Error al crear la alerta de precio';
    protected $errors = [
        'alert' => ['Error al crear la alerta de precio. Intente nuevamente.']
    ];
    protected int $status = 500;
}
