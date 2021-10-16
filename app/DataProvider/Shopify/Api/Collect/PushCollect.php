<?php

namespace App\DataProvider\Shopify\Api\Collect;

use App\DataProvider\Shopify\Api\ShopifyApi;
use App\DataProvider\Shopify\Factory\CollectFactory;
use Throwable;

/**
 * Class PushCollect
 * @package App\DataProvider\Shopify\Api\Collect
 */
final class PushCollect extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $path = 'collects.json';

    /**
     * @return bool
     */
    public function handler(): bool
    {
        $this->body = CollectFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return $response->getStatus() === 201 ? true : false;
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
