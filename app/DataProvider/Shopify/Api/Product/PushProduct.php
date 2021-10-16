<?php

namespace App\DataProvider\Shopify\Api\Product;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\Shopify\Api\ShopifyApi;
use App\DataProvider\Shopify\Factory\ProductFactory;
use Throwable;

/**
 * Class PushProduct
 * @package App\DataProvider\Shopify\Api\Product
 */
final class PushProduct extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $path = 'products.json';

    /**
     * @return DataProviderEntityInterface
     */
    public function handler(): DataProviderEntityInterface
    {
        $this->body = ProductFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();

            /** Product id */
            $productId = $this->toArray($response)['product']['id'];

            /** Sync with collections */
            $this->syncWithCollections($productId);

            return ProductFactory::fromRequest($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
