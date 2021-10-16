<?php

namespace App\DataProvider\Shopify\Mapper;

use App\DataProvider\MapperInterface;
use App\Http\Helper;

/**
 * Class CollectionMapper
 * @package App\DataProvider\Shopify\Mapper
 */
final class CollectionMapper implements MapperInterface
{
    /**
     * @return array
     */
    public static function requestToDPOMap(): array
    {
        return  [
            'id' => 'id',
            'title' => 'title',
            'body_html' => 'bodyHtml',
            'published_at' => 'publishedAt'
        ];
    }

    /**
     * @return array
     */
    public static function CoreToDPOMap(): array
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'status' => 'published',
            'extra' => 'extra'
        ];
    }

    /**
     * @return array
     */
    public static function DPOToCoreMap(): array
    {
        return Helper::flipAssociativeArray(self::CoreToDPOMap());
    }

    /**
     * @inheritDoc
     */
    public static function DPOToRequestMap(): array
    {
        //
    }
}
