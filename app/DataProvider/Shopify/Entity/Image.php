<?php

namespace App\DataProvider\Shopify\Entity;

use App\DataProvider\DataProviderEntityInterface;

/**
 * Class Image
 *
 * Doc https://shopify.dev/docs/admin-api/rest/reference/products/product-image
 *
 * @package App\DataProvider\Shopify\Entity\Product
 */
class Image implements DataProviderEntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $productId;

    /**
     * @var string
     */
    public $alt;

    /**
     * @var string
     */
    public $src;

    /**
     * @var array
     */
    public $variantIds;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;


    /**
     * Image constructor.
     */
    public function __construct()
    {
        $this->variantIds = [];
    }
}
