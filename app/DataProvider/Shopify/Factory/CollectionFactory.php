<?php

namespace App\DataProvider\Shopify\Factory;

use App\Core\Entity\Category;
use App\Core\InternalEntityInterface;
use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\FactoryInterface;
//use App\DataProvider\Shopify\Entity\Image;
use App\DataProvider\Shopify\Entity\Collection\Collection;
use App\DataProvider\Shopify\Mapper\CollectionMapper;

class CollectionFactory implements FactoryInterface
{
    /**
     * @param DataProviderEntityInterface $valueObject
     *
     * @return array
     */
    public static function toRequest(DataProviderEntityInterface $valueObject): array
    {
        return [
            'custom_collection' => (array)$valueObject
        ];
    }

    /**
     * @param array $data
     *
     * @return DataProviderEntityInterface
     */
    public static function fromRequest(array $data): DataProviderEntityInterface
    {
        $collection = new Collection();
        $map = CollectionMapper::requestToDPOMap();
        foreach ($data['custom_collection'] as $field => $value) {
            if (array_key_exists($field, $map) && property_exists($collection, $map[$field])) {
                $collection->{$map[$field]} = $value;
            }
        }

        return $collection;
    }

    /**
     * @param InternalEntityInterface $data
     *
     * @return DataProviderEntityInterface
     */
    public static function modifyRequest(InternalEntityInterface $data): DataProviderEntityInterface
    {
        $collection = new Collection();
        $map = CollectionMapper::CoreToDPOMap();
        foreach ($data as $field => $value) {
            if (array_key_exists($field, $map) && property_exists($collection, is_array($map[$field]) ? $field : $map[$field])) {
                if ($field === 'status') {
                    $collection->published = $value;
                    $collection->publishedAt = !$value ? null : date('c');
                } elseif ($field === 'id') {
                    $collection->{$map[$field]} = !empty($value) ? (integer)$value : $value;
                } else {
                    $collection->{$map[$field]} = $value;
                }
            } //TODO image + bodyHtml
        }

        return $collection;
    }

    /**
     * @param DataProviderEntityInterface $data
     *
     * @return InternalEntityInterface
     */
    public static function modifyResponse(DataProviderEntityInterface $data): InternalEntityInterface
    {
        $category = new Category();
        $map = CollectionMapper::DPOToCoreMap();
        foreach ($data as $field => $value) {
            if (array_key_exists($field, $map) && property_exists($category, is_array($map[$field]) ? $field : $map[$field])) {
                if ($field === 'published') {
                    $category->status = $value;
                } else {
                    $category->{$map[$field]} = $value;
                }
            }
        }

        return $category;
    }
}
