<?php

namespace App\DataProvider\InSales\Api\Product;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Api\Category\ParentCategory;
use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\ProductFactory;
use Throwable;

/**
 * Class PushProduct
 * @package App\DataProvider\InSales\Api\Product
 */
final class PushProduct extends InSalesApi
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
        $this->getWarehouse();

//        /** Sync with options for main product */
//        $providerEntity = $this->modifyProductOptions($this->providerEntity);

        $this->body = ProductFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();

            /** Product id */
            $productId = $this->toArray($response)['id'];

            /** Main variant id */
            $mainVariantId = $this->toArray($response)['variants'][0]['id'];

            /** Sync with options */
            $this->syncWithOptions();

            /** Sync with collections */
            $this->syncWithCollections($productId);

            /** Sync with images */
            $images = $this->syncWithImages($productId);

            /** Sync variants with product */
            $this->syncVariants($productId, $mainVariantId, $this->providerEntity);

            /** Add images to response */
            $responseResult = $this->addImagesToResponse($images, $this->toArray($response));

            return ProductFactory::fromRequest($responseResult);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }

    public function getWarehouse()
    {
        $parent = new ParentCategory();
        $this->providerEntity->categoryId = $parent->handler();
    }
}
