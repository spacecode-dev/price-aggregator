<?php

namespace App\DataProvider\Shopify\Api\Collect;

use App\DataProvider\Shopify\Api\ShopifyApi;
use Throwable;

/**
 * Class GetCollects
 * @package App\DataProvider\Shopify\Api\Collect
 */
final class GetCollects extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = 'collects.json?limit=250&fields=id,collection_id,product_id';

    /**
     * @return array
     */
    public function handler(): array
    {
        $this->body = [];
        try {
            $response = $this->buildRequest()->execute();
            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
