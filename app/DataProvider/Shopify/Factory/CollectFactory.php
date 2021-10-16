<?php

namespace App\DataProvider\Shopify\Factory;

use App\Core\InternalEntityInterface;
use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\FactoryInterface;
use App\DataProvider\Shopify\Mapper\CollectMapper;

class CollectFactory implements FactoryInterface
{
    /**
     * @param DataProviderEntityInterface $valueObject
     * @return array
     */
    public static function toRequest(DataProviderEntityInterface $valueObject): array
    {
        $collect = [];
        $map = CollectMapper::DPOToRequestMap();
        foreach ($valueObject as $field => $value) {
            if(array_key_exists($field, $map) && property_exists($valueObject, $field)) {
                $collect[$map[$field]] = $value;
            }
        }
        return [
            'collect' => (array)$collect
        ];
    }

    /**
     * @param array $data
     * @return DataProviderEntityInterface
     */
    public static function fromRequest(array $data): DataProviderEntityInterface
    {
        //
    }

    /**
     * @param InternalEntityInterface $data
     * @return DataProviderEntityInterface
     */
    public static function modifyRequest(InternalEntityInterface $data): DataProviderEntityInterface
    {
        //
    }

    /**
     * @param DataProviderEntityInterface $data
     * @return InternalEntityInterface
     */
    public static function modifyResponse(DataProviderEntityInterface $data): InternalEntityInterface
    {
        //
    }
}
