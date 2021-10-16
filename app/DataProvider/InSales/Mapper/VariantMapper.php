<?php

namespace App\DataProvider\InSales\Mapper;

use App\DataProvider\MapperInterface;

/**
 * Class VariantMapper
 * @package App\DataProvider\InSales\Mapper
 */
final class VariantMapper implements MapperInterface
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
            'title' => 'title',
            'sku' => 'sku',
            'price' => 'price',
            'status' => 'available',
//            'options' => [
//                'title' => 'value',
//                'optionNameId' => 'option_name_id'
//            ],
            'quantity' => 'quantity'
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
