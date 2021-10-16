<?php

namespace App\DataProvider\Shopify\Entity\Product;

use App\DataProvider\DataProviderEntityInterface;

/**
 * Class Variant
 *
 * Doc https://shopify.dev/docs/admin-api/rest/reference/products/product-variant
 *
 * @package App\DataProvider\Shopify\Entity\Product
 */
class Variant implements DataProviderEntityInterface
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
    public $title;

    /**
     * @var float
     */
    public $price;

    /**
     * @var float
     */
    public $compareAtPrice;

    /**
     * @var integer
     */
    public $inventoryQuantity;

    /**
     * @var string
     */
    public $inventoryManagement = 'shopify';

    /**
     * @var string
     */
    public $inventoryPolicy = 'continue';

    /**
     * @var string
     */
    public $sku;

    /**
     * @var string
     */
    public $barcode;

    /**
     * @var string
     */
    public $option1;

    /**
     * @var string
     */
    public $option2;

    /**
     * @var string
     */
    public $option3;

    /**
     * @var integer
     */
    public $imageId;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;
}
