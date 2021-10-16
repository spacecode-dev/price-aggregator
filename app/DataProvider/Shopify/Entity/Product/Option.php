<?php

namespace App\DataProvider\Shopify\Entity\Product;

use App\DataProvider\DataProviderEntityInterface;

/**
 * Class Option DTO (Data Transfer Object)
 *
 * @package App\DataProvider\Shopify\Entity\Collection
 */
class Option implements DataProviderEntityInterface
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
    public $name;


    /**
     * @var array
     */
    public $values;

    /**
     * Option constructor.
     */
    public function __construct()
    {
        $this->values = [];
    }
}
