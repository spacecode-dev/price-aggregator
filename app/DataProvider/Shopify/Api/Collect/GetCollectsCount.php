<?php

namespace App\DataProvider\Shopify\Api\Collect;

use App\DataProvider\Shopify\Api\ShopifyApi;
use Throwable;

/**
 * Class GetCollectsCount
 * @package App\DataProvider\Shopify\Api\Collect
 */
final class GetCollectsCount extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = 'collects/count.json';

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
