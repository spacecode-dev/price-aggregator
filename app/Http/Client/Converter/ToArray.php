<?php

namespace App\Http\Client\Converter;

/**
 * Interface ToArray
 * @package App\Http\Client\Converter
 */
interface ToArray
{
    /**
     * @param $data string[][]
     *
     * @return array
     */
    public function toArray($data): array;
}
