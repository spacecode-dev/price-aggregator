<?php

namespace App\DataProvider\Shopify\Api;

use App\DataProvider\AbstractRequest;
use App\DataProvider\Shopify\Api\Collect\DeleteCollect;
use App\DataProvider\Shopify\Api\Collect\GetCollects;
use App\DataProvider\Shopify\Api\Collect\GetCollectsCount;
use App\DataProvider\Shopify\Api\Collect\PushCollect;
use App\DataProvider\Shopify\Api\Collection\CheckCollection;
use App\DataProvider\Shopify\Config;
use App\DataProvider\Shopify\Entity\Collection\Collect;
use App\Http\Client\ResponseToArray;

/**
 * Class ShopifyRequest
 * @package App\DataProvider\Shopify\Api
 */
abstract class ShopifyApi extends AbstractRequest
{
    use ResponseToArray;

    /**
     * @var string
     */
    protected $contentType = 'json';

    /**
     * ShopifyRequest constructor.
     */
    public function __construct()
    {
        $this->config = Config::init();
    }

    /**
     * @param $compareWith
     * @param null $id
     */
    protected function removeCollects($compareWith, $id)
    {
        foreach ($this->getCollectsArray() as $col) {
            if($col[$compareWith] !== $id) {
                continue;
            }
            $deleteCollect = new DeleteCollect();
            $deleteCollect->id = $col['id'];
            $deleteCollect->handler();
        }
    }

    protected function syncWithCollections($id)
    {
        foreach ($this->providerEntity->extra['categories'] as $categoryId) {
            $collection = new CheckCollection();
            $collection->id = $categoryId;
            if($collection->handler()) {
                $collect = new Collect();
                $collect->collectionId = $categoryId;
                $collect->productId = $id;
                $collectConnection = new PushCollect();
                $collectConnection->setProviderEntity($collect);
                $collectConnection->handler();
            }
        }
    }

    /**
     * @return array
     */
    private function getCollectsArray()
    {
        $counter = 0;
        $countCollects = new GetCollectsCount();
        $countOfPasses = intval(ceil($countCollects->handler()['count'] / 250));

        $collectsArray = [];
        while ($counter < $countOfPasses) {
            $collects = new GetCollects();
            $collectsArray = array_merge($collectsArray, $collects->handler()['collects']);
            $counter++;
        }
        return $collectsArray;
    }
}
