<?php

namespace App\Http\Client\Converter;

/**
 * Interface ResponseToJson
 * @package App\Http\Client\Response
 */
interface ToJson
{
    /**
     * @param $data mixed
     *
     * @return string
     */
    public function toJson(array $data): string;
}
