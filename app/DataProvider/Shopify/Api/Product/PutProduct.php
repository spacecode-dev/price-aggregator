<?php

namespace App\DataProvider\Shopify\Api\Product;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\Shopify\Api\ShopifyApi;
use App\DataProvider\Shopify\Factory\ProductFactory;
use Throwable;

/**
 * Class PutProduct
 * @package App\DataProvider\Shopify\Api\Product
 */
final class PutProduct extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'PUT';

    /**
     * @var string
     */
    protected $path = 'products/#{id}.json';

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
        $this->body = ProductFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();

            /** Remove all collects */
            $this->removeCollects('product_id', $this->providerEntity->id);

            /** Sync with collections */
            $this->syncWithCollections($this->providerEntity->id);

            return ProductFactory::fromRequest($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
