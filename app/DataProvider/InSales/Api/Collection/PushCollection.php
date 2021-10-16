<?php

namespace App\DataProvider\InSales\Api\Collection;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\CollectionFactory;
use Throwable;

/**
 * Class PushCollection
 * @package App\DataProvider\InSales\Api\Collection
 */
final class PushCollection extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $path = 'collections.json';

    /**
     * @return DataProviderEntityInterface
     */
    public function handler(): DataProviderEntityInterface
    {
        $this->getCatalog();
        $this->body = CollectionFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return CollectionFactory::fromRequest($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }

    public function getCatalog()
    {
        if($this->providerEntity->parentId === 0) {
            $parent = new ParentCollection();
            $this->providerEntity->parentId = $parent->handler();
        }
    }
}
