<?php

namespace App\DataProvider\InSales\Entity\Collection;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Entity\Image;

/**
 * Class Collection
 *
 * Doc https://api.insales.ru/?doc_format=JSON#collection-create-collection-json
 *
 * @package App\DataProvider\InSales\Entity\Collection
 */
class Collection implements DataProviderEntityInterface
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $parentId = 0;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $htmlTitle;

    /**
     * @var boolean
     */
    public $isHidden = false;

    /**
     * @var Image[]
     */
    public $images;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $seoDescription;

    /**
     * @var string
     */
    public $metaDescription;

    /**
     * @var string
     */
    public $metaKeywords;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;

    /**
     * Collection constructor.
     */
    public function __construct()
    {
        $this->images = [];
    }
}
