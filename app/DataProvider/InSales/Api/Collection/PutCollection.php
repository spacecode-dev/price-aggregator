<?php

namespace App\DataProvider\InSales\Api\Collection;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\CollectionFactory;
use Throwable;

/**
 * Class PutCollection
 * @package App\DataProvider\InSales\Api\Collection
 */
final class PutCollection extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'PUT';

    /**
     * @var string
     */
    protected $path = 'collections/#{id}.json';

    /**
     * @return void
     */
    public function changePath()
    {
        $this->path = str_replace('#{id}', $this->providerEntity->id, $this->path);
    }

    /**
     * @return DataProviderEntityInterface
     */
    public function handler(): DataProviderEntityInterface
    {
        unset($this->providerEntity->parentId);
        $this->changePath();
        $this->body = CollectionFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return CollectionFactory::fromRequest($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
