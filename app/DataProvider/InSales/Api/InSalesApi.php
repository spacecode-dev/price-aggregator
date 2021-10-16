<?php

namespace App\DataProvider\InSales\Api;

use App\DataProvider\AbstractRequest;
use App\DataProvider\DataProviderApiInterface;
use App\DataProvider\InSales\Api\Collect\DeleteCollect;
use App\DataProvider\InSales\Api\Collect\GetCollectsByProduct;
use App\DataProvider\InSales\Api\Collect\PushCollect;
use App\DataProvider\InSales\Api\Collection\CheckCollection;
use App\DataProvider\InSales\Api\Image\DeleteImage;
use App\DataProvider\InSales\Api\Image\GetImages;
use App\DataProvider\InSales\Api\Image\PushImageBySrc;
use App\DataProvider\InSales\Api\Option\GetOptionNames;
use App\DataProvider\InSales\Api\Option\GetOptionValues;
use App\DataProvider\InSales\Api\Option\PushOptionName;
use App\DataProvider\InSales\Api\Option\PushOptionValue;
use App\DataProvider\InSales\Config;
use App\DataProvider\InSales\Entity\Collection\Collect;
use App\DataProvider\InSales\Entity\Product\Option;
use App\DataProvider\InSales\Entity\Product\Variant;
use App\DataProvider\InSales\Mapper\ProductMapper;
use App\DataProvider\ServiceResolver;
use App\Http\Client\ResponseToArray;

/**
 * Class InSalesRequest
 * @package App\DataProvider\InSales\Api
 */
abstract class InSalesApi extends AbstractRequest
{
    use ResponseToArray, ServiceResolver;

    /**
     * @var string
     */
    protected $contentType = 'json';

    /**
     * InSalesRequest constructor.
     */
    public function __construct()
    {
        $this->config = Config::init();
    }

    /**
     * Option functions
     */

    /**
     * @return array
     */
    private function checkFeaturesOnAvailable()
    {
        $readyFeatures = [];
        foreach ($this->providerEntity->extra['features'] as $feature) {
            $optionNamesConnection = new GetOptionNames();
            foreach ($optionNamesConnection->handler() as $option) {
                if($option['title'] !== $feature['key']) {
                    continue;
                }
                $feature['optionId'] = $option['id'];
            }
            $readyFeatures[] = $feature;
        }
        return $readyFeatures;
    }

    /**
     * Sync
     */
    protected function syncWithOptions()
    {
        $array = $this->checkFeaturesOnAvailable();
        foreach ($array as $item) {
            if(isset($item['optionId'])) {
                $this->syncOptionValues($item);
            } else {
                $this->createOption($item);
            }
        }
    }

    /**
     * @param $item
     */
    protected function syncOptionValues($item)
    {
        $optionValuesConnection = new GetOptionValues();
        $optionValuesConnection->id = $item['optionId'];

        $itemValues = collect($item['value']);
        $optionValues = collect($optionValuesConnection->handler())->pluck('title')->toArray();
        $diff = $itemValues->diff($optionValues);

        if(count($diff)) {
            foreach ($diff as $value) {
                $this->addOptionValue($value, $item['optionId']);
            }
        }
    }

    /**
     * @param $item
     */
    protected function createOption($item)
    {
        $option = new Option();
        $option->type = 'option_name';
        $option->title = $item['key'];

        $optionNameConnection = new PushOptionName();
        $optionNameConnection->setProviderEntity($option);
        $optionId = $optionNameConnection->handler()['id'];
        foreach ($item['value'] as $value) {
            $this->addOptionValue($value, $optionId);
        }
    }

    /**
     * @param $val
     * @param $id
     */
    private function addOptionValue($val, $id)
    {
        $option = new Option();
        $option->type = 'option_value';
        $option->title = $val;
        $optionValueConnection = new PushOptionValue();
        $optionValueConnection->setProviderEntity($option);
        $optionValueConnection->id = $id;
        $optionValueConnection->handler();
    }

    /**
     * Variant function
     */

    /**
     * @param $id
     * @param $varId
     * @param $entity
     */
//    protected function syncVariants($id, $varId, $entity)
    protected function syncVariants($id, $varId, $entity)
    {
        $entity->extra['variants'][0]['id'] = $varId;
        if(isset($entity->extra['variants']) && count($entity->extra['variants'])) {
            foreach ($entity->extra['variants'] as $var) {
                $variant = new Variant();
                $map = ProductMapper::requestToDPOMap()['variants'];
                foreach ($var as $key => $value) {
                    $checkField = $key;
                    if($key === 'features') {
                        $checkField = 'options';
                    }
                    if(array_key_exists($key, $map) && property_exists($variant, is_array($map[$key]) ? $checkField : $map[$key])) {
                        if(is_array($value) && $key === 'features' && count($value)) {
//                            foreach ($value as $option) {
//                                $property = new Option();
//                                foreach ($option as $propKey => $propVal) {
//                                    if(array_key_exists($propKey, $map[$key]) && property_exists($property, $map[$key][$propKey])) {
//                                        if($map[$key][$propKey] === 'optionNameId') {
//                                            $readyValue = $this->getOptionIdByName($propVal);
//                                        } else {
//                                            $readyValue = $propVal;
//                                        }
//                                        $property->{$map[$key][$propKey]} = $readyValue;
//                                        unset($property->type);
//                                    }
//                                }
//                                $variant->{$checkField}[] = $property;
//                            }
                        } else {
                            $variant->{$map[$key]} = $value;
                        }
                    }
                }

                $action = isset($variant->id) ? 'put' : 'push';
                $dataProvider = $this->findServiceByName('insales', 'variant', $action);

                /** @var DataProviderApiInterface $dataProviderConnection */
                $dataProviderConnection = new $dataProvider();
                $dataProviderConnection->id = $id;
                if($action === 'put') {
                    $dataProviderConnection->varId = $variant->id;
                }
                $dataProviderConnection->setProviderEntity($variant);
                $dataProviderConnection->handler();
            }
        }
    }

    /**
     * @param $val
     * @return integer
     */
    private function getOptionIdByName($val)
    {
        $optionNamesConnection = new GetOptionNames();
        $readyValue = 0;
        foreach ($optionNamesConnection->handler() as $option) {
            if($option['title'] !== $val) {
                continue;
            }
            $readyValue = intval($option['id']);
        }
        return $readyValue;
    }

//    protected function modifyProductOptions($entity)
//    {
//        if(property_exists($entity, 'variantsAttributes') && count($entity->variantsAttributes)) {
//            foreach ($entity->variantsAttributes as $variantIndex => $variants) {
//                if(property_exists($variants, 'options') && count($variants->options)) {
//                    foreach ($variants->options as $optionIndex => $options) {
//                        $entity->variantsAttributes[$variantIndex]->options[$optionIndex]->optionNameId = $this->getOptionIdByName($options->optionNameId);
//                    }
//                }
//            }
//        }
//        return $entity;
//    }

    /**
     * Collect and Collection functions
     */

    /**
     * @param $id
     */
    protected function syncWithCollections($id)
    {
        foreach ($this->providerEntity->extra['categories'] as $categoryId) {
            $collection = new CheckCollection();
            $collection->id = $categoryId;
            if($collection->handler()) {
                $collect = new Collect();
                $collect->collectionId = $categoryId;
                $collect->productId = $id;
                $collectConnection = new PushCollect();
                $collectConnection->setProviderEntity($collect);
                $collectConnection->handler();
            }
        }
    }

    /**
     * @param $compareWith
     * @param null $id
     */
    protected function removeCollects($compareWith, $id)
    {
        $collects = new GetCollectsByProduct();
        $collects->id = $id;
        foreach ($collects->handler() as $col) {
            if($col[$compareWith] !== $id) {
                continue;
            }
            $deleteCollect = new DeleteCollect();
            $deleteCollect->id = $col['id'];
            $deleteCollect->handler();
        }
    }


    /**
     * Images functions
     */

    /**
     * @param $id
     * @return array
     */
    protected function syncWithImages($id)
    {
        $this->removeImages($id);
        return $this->pushImages($id);
    }

    /**
     * @param $id
     * @return array
     */
    private function pushImages($id)
    {
        $imageArray = [];
        foreach ($this->providerEntity->images as $image) {
            $imageConnection = new PushImageBySrc();
            $imageConnection->id = $id;
            $imageConnection->setProviderEntity($image);
            $imageArray[] = json_decode(json_encode($imageConnection->handler()), true);
        }
        return $imageArray;
    }

    /**
     * @param $id
     */
    protected function removeImages($id)
    {
        $imageConnection = new GetImages();
        $imageConnection->id = $id;
        foreach ($imageConnection->handler() as $image) {
            $deleteImage = new DeleteImage();
            $deleteImage->id = $image['product_id'];
            $deleteImage->imageId = $image['id'];
            $deleteImage->handler();
        }
    }

    /**
     * @param $images
     * @param $response
     * @return array
     */
    protected function addImagesToResponse($images, $response)
    {
        if(count($images)) {
            $response['images'] = $images;
        }
        return $response;
    }
}
