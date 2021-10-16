<?php

namespace App\DataProvider\InSales\Api\Product;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\ProductFactory;
use Throwable;

/**
 * Class PutProduct
 * @package App\DataProvider\InSales\Api\Product
 */
final class PutProduct extends InSalesApi
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

            /** Sync with images */
            $images = $this->syncWithImages($this->providerEntity->id);

            /** Add images to response */
            $responseResult = $this->addImagesToResponse($images, $this->toArray($response));

            return ProductFactory::fromRequest($responseResult);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
