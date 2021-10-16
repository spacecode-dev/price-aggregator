<?php

namespace App\Core\Entity;

use App\Core\InternalEntityInterface;

/**
 * Class Category
 * @package App\Core\Entity
 */
class Category implements InternalEntityInterface
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
     * @var boolean
     */
    public $status;

    /**
     * @var array
     */
    public $extra;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->extra = [];
    }
}
