<?php

namespace App\Http\Client\Response;

/**
 * Interface ResponseInterface
 * @package App\Http\Client\Response
 */
interface HttpResponseInterface
{
    /**
     * @return string[][]
     */
    public function getHeaders(): array;

    /**
     * @return mixed
     */
    public function getStatus(): int;

    /**
     * @return string
     */
    public function getContent(): string;
}
