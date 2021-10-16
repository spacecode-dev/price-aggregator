<?php

namespace App\DataProvider\InSales\Factory;

use App\Core\InternalEntityInterface;
use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\FactoryInterface;

class CategoryFactory implements FactoryInterface
{
    /**
     * @param DataProviderEntityInterface $valueObject
     *
     * @return array
     */
    public static function toRequest(DataProviderEntityInterface $valueObject): array
    {

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
