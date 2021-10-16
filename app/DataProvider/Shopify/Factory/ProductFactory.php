<?php

namespace App\DataProvider\Shopify\Factory;

use App\Core\Entity\Product as CoreProduct;
use App\Core\Entity\Product\Feature as CoreProductFeature;
use App\Core\Entity\Product\Variant as CoreProductVariant;
use App\Core\Entity\Product\Image as CoreProductImage;
use App\Core\InternalEntityInterface;
use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\FactoryInterface;
use App\DataProvider\Shopify\Entity\Image;
use App\DataProvider\Shopify\Entity\Product\Option;
use App\DataProvider\Shopify\Entity\Product\Product;
use App\DataProvider\Shopify\Entity\Product\Variant;
use App\DataProvider\Shopify\Mapper\ProductMapper;
use Illuminate\Support\Collection;

class ProductFactory implements FactoryInterface
{

    /**
     * @param DataProviderEntityInterface $valueObject
     *
     * @return array
     */
    public static function toRequest(DataProviderEntityInterface $valueObject): array
    {
        $product = [];
        $map = ProductMapper::DPOToRequestMap();
        foreach ($valueObject as $field => $value) {
            if(array_key_exists($field, $map) && property_exists($valueObject, $field)) {
                if($field !== 'tags' && is_array($value) && count($value)) {
                    $i = 0;
                    foreach ($value as $val) {
                        $prop = [];
                        foreach ($val as $k => $v) {
                            if(array_key_exists($k, $map[$field]) && property_exists($valueObject->{$field}[$i], $k)) {
                                $prop[$map[$field][$k]] = $v;
                            }
                        }
                        $product[$field][] = $prop;
                        $i++;
                    }
                } else {
                    $product[$map[$field]] = $value;
                }
            }
        }
        return [
            'product' => (object)$product
        ];
    }

    /**
     * @param array $data
     *
     * @return DataProviderEntityInterface
     */
    public static function fromRequest(array $data): DataProviderEntityInterface
    {
        $product = new Product();
        $map = ProductMapper::requestToDPOMap();
        foreach ($data['product'] as $field => $value) {
            if(array_key_exists($field, $map) && property_exists($product, is_array($map[$field]) ? $field : $map[$field])) {
                if(is_array($value)) {
                    $property = null;
                    foreach ($value as $collection) {
                        if($field === 'images') {
                            $property = new Image();
                        } else if ($field === 'variants') {
                            $property = new Variant();
                        } else if ($field === 'options') {
                            $property = new Option();
                        }
                        if($property) {
                            foreach ($collection as $key => $val) {
                                if(array_key_exists($key, $map[$field]) && property_exists($property, $map[$field][$key])) {
                                    $property->{$map[$field][$key]} = $val;
                                }
                            }
                            $product->{$field}[] = $property;
                        }
                    }
                } else {
                    $product->{$map[$field]} = $value;
                }
            }
        }
        return $product;
    }

    /**
     * @param InternalEntityInterface $internalEntity
     * @return DataProviderEntityInterface
     */
    public static function modifyRequest(InternalEntityInterface $internalEntity): DataProviderEntityInterface
    {
        $product = new Product();
        $map = ProductMapper::CoreToDPOMap();
        foreach ($internalEntity as $field => $value) {
            $checkField = $field;
            if($field === 'features') {
                $checkField = 'options';
            }
            if(array_key_exists($field, $map) && property_exists($product, is_array($map[$field]) ? $checkField : $map[$field])) {
                if ($value instanceof Collection) {
                    $property = null;
                    foreach ($value as $collection) {
                        if($field === 'images') {
                            $property = new Image();
                        } else if ($field === 'variants') {
                            $property = new Variant();
                        } else if ($field === 'features') {
                            $property = new Option();
                        }
                        if($property) {
                            foreach ($collection as $key => $val) {
                                if(array_key_exists($key, $map[$field]) && property_exists($property, $map[$field][$key])) {
                                    $property->{$map[$field][$key]} = $val;
                                    if($field === 'variants') {
                                        if(empty($val)) {
                                            if($key === 'title' || $key === 'sku' || $key === 'price' || $key === 'salePrice' || $key === 'quantity') {
                                                $property->{$map[$field][$key]} = $internalEntity->{$key};
                                            } elseif ($key === 'productId') {
                                                $property->{$map[$field][$key]} = (integer)$internalEntity->id;
                                            }
                                        } else {
                                            if($key === 'option1' || $key === 'option2' || $key === 'option3') {
                                                $optionIndex = intval(str_replace('option', '', $key)) - 1;
                                                $optionKey = $internalEntity->features[$optionIndex]->key;
                                                $product->tags[] = $optionKey . ' ' .  $val;
                                            }
                                        }
                                    }
                                }
                            }
                            $product->{$checkField}[] = $property;
                        }
                    }
                } elseif($field === 'status') {
                    $product->{$map[$field]} = !$value ? null : date('c');
                } elseif ($field === 'id') {
                    $product->{$map[$field]} = !empty($value) ? (integer)$value : $value;
                } else {
                    $product->{$map[$field]} = $value;
                }
            } elseif ($field === 'categories') {
                $product->extra[$field] = $value;
            }
        }
        if(empty($product->variants)) {
            $product->variants[] = new Variant();
            foreach ($internalEntity as $field => $value) {
                $variant = $map['variants'];
                if(array_key_exists($field, $variant)) {
                    $mapField = $variant[$field];
                    if(empty($product->variants[0]->{$mapField})) {
                        $product->variants[0]->{$mapField} = $value;
                    }
                }
            }
        }
        return $product;
    }

    /**
     * @param DataProviderEntityInterface $data
     * @return InternalEntityInterface
     */
    public static function modifyResponse(DataProviderEntityInterface $data): InternalEntityInterface
    {
        $product = new CoreProduct();
        $map = ProductMapper::DPOToCoreMap();
        foreach ($data as $field => $value) {
            $checkField = $field;
            if($field === 'options') {
                $checkField = 'features';
            }
            if(array_key_exists($checkField, $map) && property_exists($product, is_array($map[$checkField]) ? $checkField : $map[$checkField])) {
                if(is_array($value)) {
                    $property = null;
                    $i = 0;
                    foreach ($value as $collection) {
                        $property = null;
                        if($field === 'images') {
                            $property = new CoreProductImage();
                        } else if ($field === 'variants') {
                            $property = new CoreProductVariant();
                        } else if ($field === 'options') {
                            $property = new CoreProductFeature();
                        }
                        if($property) {
                            foreach ($collection as $key => $val) {
                                if(array_key_exists($key, $map[$checkField]) && property_exists($property, $map[$checkField][$key])) {
                                    $property->{$map[$checkField][$key]} = $val;
                                    if($field === 'variants' && !$i) {
                                        if($key === 'sku' || $key === 'price' || $key === 'compareAtPrice' || $key === 'inventoryQuantity') {
                                            $product->{$map[$field][$key]} = $val;
                                        }
                                    }
                                } else if ($key === 'option1' || $key === 'option2' || $key === 'option3') {
                                    $optionIndex = intval(str_replace('option', '', $key)) - 1;
                                    if(!empty($val)) {
                                        $propertyFeature = new CoreProductFeature();
                                        $propertyFeature->key = $data->options[$optionIndex]->name;
                                        $propertyFeature->value = $val;
                                        $property->features[] = $propertyFeature;
                                    }
                                }
                            }
                            $product->{$checkField}[] = $property;
                            $i++;
                        }
                    }
                } elseif ($field === 'publishedAt') {
                    $product->{$map[$field]} = $value === null ? false : true;
                } else {
                    $product->{$map[$field]} = $value;
                }
            }
        }
        return $product;
    }
}
