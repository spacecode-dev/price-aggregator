<?php

namespace App\DataProvider\InSales\Entity;

use App\DataProvider\DataProviderEntityInterface;

/**
 * Class Image
 *
 * Doc https://api.insales.ru/?doc_format=JSON#image-create-image-from-src-json
 *
 * @package App\DataProvider\InSales\Entity\Product
 */
class Image implements DataProviderEntityInterface
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
    public $title;

    /**
     * @var integer
     */
    public $externalId;

    /**
     * @var string
     */
    public $createdAt;
}
