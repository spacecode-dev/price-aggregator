<?php

namespace App\Core\Entity\Product;

use App\Core\InternalEntityInterface;

/**
 * Class Shipping
 * @package App\Core\Entity\Product
 */
class Shipping implements InternalEntityInterface
{
    /**
     * @var string
     */
    public $weight;

    /**
     * @var string
     */
    public $weightMeasure;

    /**
     * @var string
     */
    public $size;

    /**
     * @var string
     */
    public $sizeMeasure;

    /**
     * @var array
     */
    public $countries;

    /**
     * Shipping constructor.
     */
    public function __construct()
    {
        $this->countries = [];
    }
}
