<?php

namespace App\Core\Entity\Product;

use App\Core\InternalEntityInterface;

/**
 * Class Image
 * @package App\Core\Entity\Product
 */
class Image implements InternalEntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $src;

    /**
     * @var string
     */
    public $extension;

    /**
     * @var boolean
     */
    public $default = false;
}
