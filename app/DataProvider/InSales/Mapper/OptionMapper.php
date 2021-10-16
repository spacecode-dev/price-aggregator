<?php

namespace App\DataProvider\InSales\Mapper;

use App\DataProvider\MapperInterface;

/**
 * Class OptionMapper
 * @package App\DataProvider\InSales\Mapper
 */
final class OptionMapper implements MapperInterface
{
    /**
     * @return array
     */
    public static function requestToDPOMap(): array
    {
        return  [];
    }

    /**
     * @inheritDoc
     */
    public static function DPOToRequestMap(): array
    {
        return  [
            'title' => 'title'
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
