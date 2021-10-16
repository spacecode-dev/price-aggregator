<?php

namespace App\Exceptions;

use Throwable;

/**
 * Class BadCredentials
 * @package App\Exceptions
 */
class BadCredentials extends \Exception
{
    /**
     * The status code to use for the response.
     *
     * @var int
     */
    private $status = 422;

    /**
     * BadCredentials constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "The given data is invalid", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
