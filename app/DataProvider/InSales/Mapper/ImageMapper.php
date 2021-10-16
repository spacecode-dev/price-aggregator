<?php

namespace App\DataProvider\InSales\Mapper;

use App\DataProvider\MapperInterface;

/**
 * Class ImageMapper
 * @package App\DataProvider\InSales\Mapper
 */
final class ImageMapper implements MapperInterface
{
    /**
     * @return array
     */
    public static function requestToDPOMap(): array
    {
        return  [
            'id' => 'id'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function DPOToRequestMap(): array
    {
        return  [
            'id' => 'id',
            'src' => 'src'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function CoreToDPOMap(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function DPOToCoreMap(): array
    {
        return [];
    }
}
