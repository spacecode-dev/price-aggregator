<?php

namespace App\DataProvider\InSales\Entity\Collection;

use App\DataProvider\DataProviderEntityInterface;

/**
 * Class Collect
 * Reference between Product and Collection
 *
 * Doc https://api.insales.ru/?doc_format=JSON#collect-add-product-to-collection-json
 *
 * @package App\DataProvider\InSales\Entity\Collection
 */
class Collect implements DataProviderEntityInterface
{
    /**
     * @var integer
     */
    public $productId;

    /**
     * @var integer
     */
    public $collectionId;
}
