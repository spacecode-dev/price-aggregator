<?php

namespace App\DataProvider\InSales\Factory;

use App\Core\InternalEntityInterface;
use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\FactoryInterface;
use App\DataProvider\InSales\Mapper\VariantMapper;

class VariantFactory implements FactoryInterface
{
    /**
     * @param DataProviderEntityInterface $valueObject
     *
     * @return array
     */
    public static function toRequest(DataProviderEntityInterface $valueObject): array
    {
        $variant = [];
        $map = VariantMapper::DPOToRequestMap();
        foreach ($valueObject as $field => $value) {
            if(array_key_exists($field, $map) && property_exists($valueObject, is_array($map[$field]) ? $field : $map[$field])) {
                if(is_array($value)) {
                    $i = 0;
                    foreach ($value as $val) {
                        $prop = [];
                        foreach ($val as $k => $v) {
                            if(array_key_exists($k, $map[$field]) && property_exists($valueObject->{$field}[$i], $k)) {
                                $prop[$map[$field][$k]] = $v;
                            }
                        }
                        $variant[$field][] = $prop;
                        $i++;
                    }
                } else {
                    $variant[$map[$field]] = $value;
                }
            }
        }
        return [
            'variant' => (array)$variant
        ];
    }

    /**
     * @param array $data
     *
     * @return DataProviderEntityInterface
     */
    public static function fromRequest(array $data): DataProviderEntityInterface
    {

    }

    /**
     * @param InternalEntityInterface $data
     *
     * @return DataProviderEntityInterface
     */
    public static function modifyRequest(InternalEntityInterface $data): DataProviderEntityInterface
    {

    }

    /**
     * @param DataProviderEntityInterface $data
     *
     * @return InternalEntityInterface
     */
    public static function modifyResponse(DataProviderEntityInterface $data): InternalEntityInterface
    {

    }
}
