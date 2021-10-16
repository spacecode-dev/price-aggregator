<?php

namespace App\DataProvider\InSales\Mapper;

use App\DataProvider\MapperInterface;

/**
 * Class CollectionMapper
 * @package App\DataProvider\InSales\Mapper
 */
final class CollectMapper implements MapperInterface
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
            'productId' => 'product_id',
            'collectionId' => 'collection_id'
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
