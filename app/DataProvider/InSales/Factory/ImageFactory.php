<?php

namespace App\DataProvider\InSales\Factory;

use App\Core\InternalEntityInterface;
use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\FactoryInterface;
use App\DataProvider\InSales\Entity\Image;
use App\DataProvider\InSales\Mapper\ImageMapper;

class ImageFactory implements FactoryInterface
{
    /**
     * @param DataProviderEntityInterface $valueObject
     *
     * @return array
     */
    public static function toRequest(DataProviderEntityInterface $valueObject): array
    {
        $image = [];
        $map = ImageMapper::DPOToRequestMap();
        foreach ($valueObject as $field => $value) {
            if(array_key_exists($field, $map) && property_exists($valueObject, $field)) {
                $image[$map[$field]] = $value;
            }
        }
        return [
            'image' => (array)$image
        ];
    }

    /**
     * @param array $data
     *
     * @return DataProviderEntityInterface
     */
    public static function fromRequest(array $data): DataProviderEntityInterface
    {
        $image = new Image();
        $map = ImageMapper::requestToDPOMap();
        foreach ($data as $field => $value) {
            if(array_key_exists($field, $map) && property_exists($image, $map[$field])) {
                $image->{$map[$field]} = $value;
            }
        }
        return $image;
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
