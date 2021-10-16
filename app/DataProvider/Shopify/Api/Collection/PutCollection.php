<?php

namespace App\DataProvider\Shopify\Api\Collection;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\Shopify\Api\ShopifyApi;
use App\DataProvider\Shopify\Factory\CollectionFactory;
use Throwable;

/**
 * Class PutCollection
 * @package App\DataProvider\Shopify\Api\Collection
 */
final class PutCollection extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'PUT';

    /**
     * @var string
     */
    protected $path = 'custom_collections/#{id}.json';

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
