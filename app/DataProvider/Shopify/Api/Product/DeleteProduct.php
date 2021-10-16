<?php

namespace App\DataProvider\Shopify\Api\Product;

use App\DataProvider\Shopify\Api\Collect\DeleteCollect;
use App\DataProvider\Shopify\Api\Collect\GetCollects;
use App\DataProvider\Shopify\Api\Collect\GetCollectsCount;
use App\DataProvider\Shopify\Api\ShopifyApi;
use Throwable;

/**
 * Class DeleteProduct
 * @package App\DataProvider\Shopify\Api\Product
 */
final class DeleteProduct extends ShopifyApi
{
    /**
     * @var string
     */
    protected $method = 'DELETE';

    /**
     * @var string
     */
    protected $path = 'products/#{id}.json';

    /**
     * @var integer
     */
    public $id;

    /**
     * @return void
     */
    public function changePath()
    {
        $this->path = str_replace('#{id}', $this->id, $this->path);
    }

    /**
     * @return array
     */
    public function handler(): array
    {
        $this->changePath();
        $this->body = [];
        try {
            $response = $this->buildRequest()->execute();

            /** Add all collects */
            $this->removeCollects('product_id', $this->id);

            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
