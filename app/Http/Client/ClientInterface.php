<?php

namespace App\Http\Client;

use App\Http\Client\Request\HttpRequestInterface;
use App\Http\Client\Response\HttpResponseInterface;

/**
 * Interface ClientInterface
 * @package App\DataProvider\src
 */
interface ClientInterface
{
    /**
     * @return mixed
     */
    public function getClient();

    /**
     * @param HttpRequestInterface $request
     *
     * @return mixed
     */
    public function request(HttpRequestInterface $request): HttpResponseInterface;
}
