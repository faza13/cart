<?php


namespace Faza13\Cart\Exceptions;

use Exception;
use Throwable;

class ClientIdException extends Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        return response(
            [
                'status' => false,
                'error' =>$this->getMessage()
            ], 422
        );
    }
}