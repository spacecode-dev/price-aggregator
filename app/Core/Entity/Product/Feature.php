<?php

namespace App\Core\Entity\Product;

use App\Core\InternalEntityInterface;

/**
 * Class Feature
 * @package App\Core\Entity\Product
 */
class Feature implements InternalEntityInterface
{
    /**
     * @var string
     */
    public $key;

    /**
     * @var mixed
     */
    public $value;
}
