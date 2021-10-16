<?php

namespace App\DataProvider\Shopify\Entity\Product;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\Shopify\Entity\Image;

/**
 * Class Product DTO (Data Transfer Object)
 *
 * Doc https://shopify.dev/docs/admin-api/rest/reference/products/product
 *
 * @package App\DataProvider\Shopify\Entity\Product
 */
class Product implements DataProviderEntityInterface
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
     * @var string
     */
    public $bodyHtml;

    /**
     * @var string
     */
    public $vendor;

    /**
     * @var string
     */
    public $productType;

    /**
     * @var string
     */
    public $handle;

    /**
     * @var string
     */
    public $templateSuffix;

    /**
     * @var string
     */
    public $publishedScope = 'web';

    /**
     * @var array
     */
    public $tags;

    /**
     * @var Option []
     */
    public $options;

    /**
     * @var Variant []
     */
    public $variants;

    /**
     * @var Image []
     */
    public $images;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $publishedAt;

    /**
     * @var string
     */
    public $updatedAt;

    /**
     * @var array
     */
    public $extra;

    /**
     * CollectionDto constructor.
     */
    public function __construct()
    {
        $this->options = [];
        $this->variants = [];
        $this->tags = [];
        $this->images = [];
        $this->extra = [];
    }
}
