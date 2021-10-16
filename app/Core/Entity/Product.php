<?php

namespace App\Core\Entity;

use App\Core\Entity\Product\Feature;
use App\Core\Entity\Product\Image;
use App\Core\Entity\Product\Shipping;
use App\Core\InternalEntityInterface;
use Illuminate\Support\Collection;

/**
 * Class Product
 * @package App\Core\Entity\Product
 */
class Product implements InternalEntityInterface
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
    public $description;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $mpn;

    /**
     * @var string
     */
    public $sku;

    /**
     * @var float
     */
    public $price;

    /**
     * @var float
     */
    public $salePrice;

    /**
     * @var string
     */
    public $vendor;

    /**
     * @var array
     */
    public $categories;

    /**
     * @param \App\Core\Entity\Product\Image[]
     * @var Image []
     */
    public $images;

    /**
     * @var \App\Core\Entity\Product\Variant[]
     */
    public $variants;

    /**
     * @param \App\Core\Entity\Product\Feature[]
     * @var Feature []
     */
    public $features;

    /**
     * @param \App\Core\Entity\Product\Shipping
     * @var Shipping
     */
    public $shipping;

    /**
     * @var integer
     */
    public $quantity;

    /**
     * @var boolean
     */
    public $status = true;

    /**
     * @var array
     */
    public $extra;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->images = new Collection();
        $this->variants = new Collection();
        $this->features = new Collection();
        $this->categories = [];
        $this->extra = [];
    }
}
