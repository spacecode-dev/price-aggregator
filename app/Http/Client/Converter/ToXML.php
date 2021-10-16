<?php

namespace App\Http\Client\Converter;

/**
 * Interface ToXML
 * @package App\Http\Client\Converter
 */
interface ToXML
{
    /**
     * @param array $data
     *
     * @return string
     */
    public function toXml(array $data): string;
}
