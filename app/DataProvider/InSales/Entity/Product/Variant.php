<?php

namespace App\DataProvider\InSales\Entity\Product;

use App\DataProvider\DataProviderEntityInterface;

/**
 * Class Variant
 *
 * Doc https://api.insales.ru/?doc_format=JSON#variant-create-variant-json
 *
 * @package App\DataProvider\InSales\Entity\Product
 */
class Variant implements DataProviderEntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var integer
     */
    public $productId;

    /**
     * @var string
     */
    public $sku;

    /**
     * @var string
     */
    public $barcode;

    /**
     * @var boolean
     */
    public $available = true;

    /**
     * @var integer
     */
    public $imageId;

    /**
     * @var integer
     */
    public $quantity;

    /**
     * @var float
     */
    public $price; //TODO salePrice

    /**
     * @var Option[]
     */
    public $options;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->options = [];
    }
}
