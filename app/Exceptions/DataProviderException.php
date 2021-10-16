<?php

namespace App\Exceptions;

use Exception;

final class DataProviderException extends Exception
{
    /**
     * DataProviderException constructor.
     * @param null $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $code, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
