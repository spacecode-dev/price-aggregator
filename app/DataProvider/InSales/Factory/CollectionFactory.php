<?php

namespace App\DataProvider\InSales\Factory;

use App\Core\Entity\Category;
use App\Core\InternalEntityInterface;
use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\FactoryInterface;
//use App\DataProvider\InSales\Entity\Image;
use App\DataProvider\InSales\Entity\Collection\Collection;
use App\DataProvider\InSales\Mapper\CollectionMapper;

class CollectionFactory implements FactoryInterface
{
    /**
     * @param DataProviderEntityInterface $valueObject
     *
     * @return array
     */
    public static function toRequest(DataProviderEntityInterface $valueObject): array
    {
        $collection = [];
        $map = CollectionMapper::DPOToRequestMap();
        foreach ($valueObject as $field => $value) {
            if(array_key_exists($field, $map) && property_exists($valueObject, is_array($map[$field]) ? $map[$field] : $field)) {
                $collection[$map[$field]] = $value;
            }
        }
        return [
            'collection' => (object)$collection
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
        foreach ($data as $field => $value) {
            if (array_key_exists($field, $map) && property_exists($collection, is_array($map[$field]) ? $field : $map[$field])) {
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
                    $collection->{$map[$field]} = !(boolean)$value;
                } elseif ($field === 'id') {
                    $collection->{$map[$field]} = !empty($value) ? (integer)$value : $value;
                } else {
                    $collection->{$map[$field]} = $value;
                }
            } //TODO image + bodyHtml + seo & meta + parent Categories
            unset($collection->images);
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
                if ($field === 'isHidden') {
                    $category->status = !(boolean)$value;
                } else {
                    $category->{$map[$field]} = $value;
                }
            }
        }

        return $category;
    }

    /**
     * @param array $data
     * @return int
     */
    public static function getParent(array $data): int
    {
        $id = 0;
        foreach ($data as $field => $value) {
            if(empty($value['parent_id'])) {
                $id = $value['id'];
            }
        }
        return $id;
    }
}
