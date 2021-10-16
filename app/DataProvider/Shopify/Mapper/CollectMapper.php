<?php

namespace App\DataProvider\Shopify\Mapper;

use App\DataProvider\MapperInterface;
use App\Http\Helper;

/**
 * Class CollectionMapper
 * @package App\DataProvider\Shopify\Mapper
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
