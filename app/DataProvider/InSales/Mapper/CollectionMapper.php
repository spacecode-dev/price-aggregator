<?php

namespace App\DataProvider\InSales\Mapper;

use App\DataProvider\MapperInterface;
use App\Http\Helper;

/**
 * Class CollectionMapper
 * @package App\DataProvider\InSales\Mapper
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
            'parent_id' => 'parentId',
            'html_title' => 'htmlTitle',
            'is_hidden' => 'isHidden',
//            'images' => [
//                'src' => 'src'
//            ],
            'description' => 'description',
            'seo_description' => 'seoDescription',
            'meta_description' => 'metaDescription',
            'meta_keywords' => 'metaKeywords',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt'
        ];
    }

    /**
     * @return array
     */
    public static function DPOToRequestMap(): array
    {
        return Helper::flipAssociativeArray(self::requestToDPOMap());
    }

    /**
     * @return array
     */
    public static function CoreToDPOMap(): array
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'status' => 'isHidden',
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
}
