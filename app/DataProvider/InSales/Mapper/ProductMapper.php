<?php

namespace App\DataProvider\InSales\Mapper;

use App\DataProvider\MapperInterface;
use App\DataProvider\ServiceResolver;

/**
 * Class ProductMapper
 * @package App\DataProvider\InSales\Mapper
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
            'category_id' => 'categoryId',
            'description' => 'description',
            'short_description' => 'shortDescription',
            'permalink' => 'permalink',
            'variants' => [
                'id' => 'id',
                'title' => 'title',
                'product_id' => 'productId',
                'sku' => 'sku',
                'barcode' => 'barcode',
                'available' => 'available',
                'quantity' => 'quantity',
//                'features' => [
//                    'key' => 'optionNameId',
//                    'value' => 'title',
//                ],
                'price' => 'price',
                'created_at' => 'createdAt',
                'updated_at' => 'updatedAt',
            ],
            'ignore_discounts' => 'ignoreDiscounts',
            'dimensions' => 'dimensions',
            'vat' => 'vat',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt'
        ];
    }

    /**
     * @return array
     */
    public static function DPOToRequestMap(): array
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'categoryId' => 'category_id',
            'description' => 'description',
            'shortDescription' => 'short_description',
            'variantsAttributes' => [
                'id' => 'id',
                'title' => 'title',
                'productId' => 'product_id',
                'sku' => 'sku',
                'barcode' => 'barcode',
                'available' => 'available',
                'quantity' => 'quantity',
                'price' => 'price',
//                'options' => [
//                    'title' => 'value',
//                    'optionNameId' => 'option_name_id',
//                ],
            ],
            'ignoreDiscounts' => 'ignore_discounts',
            'dimensions' => 'dimensions',
            'vat' => 'vat'
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
            'description' => 'description',
            'slug' => 'permalink',
            'variants' => [
                'id' => 'id',
                'productId' => 'productId',
                'title' => 'title',
                'sku' => 'sku',
                'price' => 'price',
                'status' => 'available',
                'quantity' => 'quantity',
//                'features' => [
//                    'key' => 'optionNameId',
//                    'value' => 'title'
//                ]
            ],
            'images' => [
                'id' => 'id',
                'src' => 'src'
            ],
            'features' => [
                'key' => 'key',
                'value' => 'value'
            ]
        ];
    }

    /**
     * @return array
     */
    public static function DPOToCoreMap(): array
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'description' => 'description',
            'permalink' => 'slug',
            'variantsAttributes' => [
                'id' => 'id',
                'title' => 'title',
                'productId' => 'productId',
                'permalink' => 'slug',
                'sku' => 'sku',
                'barcode' => 'barcode',
                'available' => 'status',
                'quantity' => 'quantity',
                'price' => 'price'
            ]
        ];
    }
}
