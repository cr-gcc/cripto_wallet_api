<?php

namespace App\Exceptions;

use Exception;

class BaseApiException extends Exception
{
  protected int $status = 400;

  public function render($request)
  {
    return response()->json([
      'message' => $this->getMessage(),
      'errors' => $this->errors
    ], $this->status);
  }
}
