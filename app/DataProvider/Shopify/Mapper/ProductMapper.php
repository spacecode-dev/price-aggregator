<?php

namespace App\DataProvider\Shopify\Mapper;

use App\DataProvider\MapperInterface;
use App\DataProvider\ServiceResolver;
use App\Http\Helper;

/**
 * Class ProductMapper
 * @package App\DataProvider\Shopify\Mapper
 */
final class ProductMapper implements MapperInterface
{
    use ServiceResolver;

    /**
     * @return array
     */
    public static function requestToDPOMap(): array
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'body_html' => 'bodyHtml',
            'vendor' => 'vendor',
            'handle' => 'handle',
            'product_type' => 'productType',
            'template_suffix' => 'templateSuffix',
            'published_scope' => 'publishedScope',
            'tags' => 'tags',
            'options' => [
                'id' => 'id',
                'product_id' => 'productId',
                'name' => 'name',
                'values' => 'values',
            ],
            'variants' => [
                'id' => 'id',
                'product_id' => 'productId',
                'title' => 'title',
                'price' => 'price',
                'compare_at_price' => 'compareAtPrice',
                'inventory_quantity' => 'inventoryQuantity',
                'inventory_management' => 'inventoryManagement',
                'inventory_policy' => 'inventoryPolicy',
                'sku' => 'sku',
                'barcode' => 'barcode',
                'option1' => 'option1',
                'option2' => 'option2',
                'option3' => 'option3',
                'image_id' => 'imageId',
                'created_at' => 'createdAt',
                'updated_at' => 'updatedAt',
            ],
            'images' => [
                'id' => 'id',
                'product_id' => 'productId',
                'alt' => 'alt',
                'src' => 'src',
                'variant_ids' => 'variantIds',
                'created_at' => 'createdAt',
                'updated_at' => 'updatedAt',
            ],
            'created_at' => 'createdAt',
            'published_at' => 'publishedAt',
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
            'description' => 'bodyHtml',
            'slug' => 'handle',
            'vendor' => 'vendor',
            'images' => [
                'id' => 'id',
                'src' => 'src'
            ],
            'variants' => [
                'id' => 'id',
                'productId' => 'productId',
                'title' => 'title',
                'price' => 'compareAtPrice',
                'salePrice' => 'price',
                'quantity' => 'inventoryQuantity',
                'sku' => 'sku',
                'option1' => 'option1',
                'option2' => 'option2',
                'option3' => 'option3',
//                'imageId' => 'imageId'
            ],
            'features' => [
                'key' => 'name',
                'value' => 'values'
            ],
            'status' => 'publishedAt'
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
