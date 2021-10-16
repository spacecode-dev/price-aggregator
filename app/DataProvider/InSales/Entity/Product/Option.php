<?php

namespace App\DataProvider\InSales\Entity\Product;

use App\DataProvider\DataProviderEntityInterface;

/**
 * Class Option DTO (Data Transfer Object)
 *
 * @package App\DataProvider\InSales\Entity\Option
 */
class Option implements DataProviderEntityInterface
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
    public $optionNameId;

    /**
     * @var string
     */
    public $type;
}
