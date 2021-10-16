<?php

namespace App\Core\Entity\Product;

use App\Core\InternalEntityInterface;
use Illuminate\Support\Collection;

/**
 * Class Variant
 * @package App\Core\Entity\Product
 */
class Variant implements InternalEntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var mixed
     */
    public $productId;

    /**
     * @var string
     */
    public $title;

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
     * @var integer
     */
    public $quantity;

    /**
     * @param \App\Core\Entity\Product\Image[]
     * @var Image []
     */
    public $images;

    /**
     * @param \App\Core\Entity\Product\Feature[]
     * @var Feature []
     */
    public $features;

    /**
     * @var boolean
     */
    public $status = true;

    /**
     * Variants constructor.
     */
    public function __construct()
    {
        $this->images = new Collection();
        $this->features = new Collection();
    }
}
