<?php

namespace App\DataProvider\Shopify\Api\Collection;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\Shopify\Api\ShopifyApi;
use App\DataProvider\Shopify\Factory\CollectionFactory;
use Throwable;

/**
 * Class PushCollection
 * @package App\DataProvider\Shopify\Api\Collection
 */
final class PushCollection extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $path = 'custom_collections.json';

    /**
     * @return DataProviderEntityInterface
     */
    public function handler(): DataProviderEntityInterface
    {
        $this->body = CollectionFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return CollectionFactory::fromRequest($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
