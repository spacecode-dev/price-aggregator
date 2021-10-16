<?php

namespace App\DataProvider\Shopify\Entity\Collection;

use App\DataProvider\DataProviderEntityInterface;

/**
 * Class Collect
 * Reference between Product and Collection
 *
 * Doc https://shopify.dev/docs/admin-api/rest/reference/products/collect#create-2020-04
 *
 * @package App\DataProvider\Shopify\Entity\Collection
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
