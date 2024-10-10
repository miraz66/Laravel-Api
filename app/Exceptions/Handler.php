<?php

namespace App\Exceptions;

use App\Traits\ApiResponses;
use Exception;
use Throwable;

class Handler extends Exception
{
    use ApiResponses;
    public function render($request, Throwable $exception)
    {
        return $this->error([
            'type' => get_class($this),
            'status' => 0,
            'message' => $this->getMessage(),
            'source' => 'Line: ' . $exception->getLine() . ': ' . $exception->getFile(),
        ]);
    }
}
