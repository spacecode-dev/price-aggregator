<?php

namespace App\DataProvider\InSales\Entity\Product;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Entity\Image;

/**
 * Class Product DTO (Data Transfer Object)
 *
 * Doc https://api.insales.ru/?doc_format=JSON#product-create-product-json
 *
 * @package App\DataProvider\InSales\Entity\Product
 */
class Product implements DataProviderEntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $categoryId;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $shortDescription;

    /**
     * @var Variant[]
     */
    public $variantsAttributes;

    /**
     * @var integer|boolean
     */
    public $ignoreDiscounts = 1;

    /**
     * @var string
     */
    public $permalink;

    /**
     * @var string
     */
    public $dimensions;

    /**
     * @var integer
     */
    public $vat = -1;

    /**
     * @var Option []
     */
    public $options;

    /**
     * @var Image[]
     */
    public $images;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;

    /**
     * @var array
     */
    public $extra;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->variantsAttributes = [];
        $this->options = [];
        $this->images = [];
        $this->extra = [];
    }
}
