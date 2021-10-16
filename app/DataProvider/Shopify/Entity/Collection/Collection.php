<?php

namespace App\DataProvider\Shopify\Entity\Collection;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\Shopify\Entity\Image;

/**
 * Class Collection
 *
 * Doc https://shopify.dev/docs/admin-api/rest/reference/products/customcollection#create-2020-04
 *
 * @package App\DataProvider\Shopify\Entity\Collection
 */
class Collection implements DataProviderEntityInterface
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
    public $bodyHtml;

    /**
     * @var boolean
     */
    public $published = true;

    /**
     * @var Image
     */
    public $image;

    /**
     * @var string
     */
    public $publishedAt;

    /**
     * @var array
     */
    public $collects;

    /**
     * Collection constructor.
     */
    public function __construct()
    {
        $this->collects = [];
    }
}
