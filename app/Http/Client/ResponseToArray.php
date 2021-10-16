<?php

namespace App\Http\Client;

use App\Http\Client\Response\HttpResponseInterface;

trait ResponseToArray
{
    /**
     * @param \App\Http\Client\Response\HttpResponseInterface $response
     *
     * @return array
     */
    public function toArray(HttpResponseInterface $response): array
    {
        return json_decode($response->getContent(), true);
    }
}
