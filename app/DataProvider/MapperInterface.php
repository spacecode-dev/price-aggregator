<?php

namespace App\DataProvider;

/**
 * Interface MapperInterface
 * @package App\DataProvider
 */
interface MapperInterface
{
    /**
     * @return array
     */
    public static function requestToDPOMap(): array;

    /**
     * @return array
     */
    public static function DPOToRequestMap(): array;

    /**
     * @return array
     */
    public static function CoreToDPOMap(): array;

    /**
     * @return array
     */
    public static function DPOToCoreMap(): array;
}
