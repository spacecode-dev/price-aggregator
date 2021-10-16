<?php

namespace App\DataProvider\InSales\Factory;

use App\Core\InternalEntityInterface;
use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\FactoryInterface;
use App\DataProvider\InSales\Entity\Image;
//use App\DataProvider\InSales\Entity\Product\Option;
use App\DataProvider\InSales\Entity\Product\Product;
use App\DataProvider\InSales\Entity\Product\Variant;
use App\DataProvider\InSales\Mapper\ProductMapper;
use App\Core\Entity\Product as CoreProduct;
use App\Core\Entity\Product\Variant as CoreProductVariant;
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
//        foreach ($valueObject as $field => $value) {
//            $property = $field;
//            if($field === 'variantsAttributes') {
//                $property = 'variants_attributes';
//            }
//            if(array_key_exists($field, $map) && property_exists($valueObject, $field)) {
//                if(is_array($value) && count($value)) {
//                    foreach ($value as $internalKey => $internalValue) {
//                        $prop = [];
//                        foreach ($internalValue as $objKey => $objValue) {
//                            if(array_key_exists($objKey, $map[$field]) && property_exists($valueObject->{$field}[$internalKey], $objKey)) {
//                                if(is_array($objValue) && count($objValue)) {
//                                    foreach ($objValue as $key => $val) {
//                                        $proper = [];
//                                        foreach ($val as $valKey => $valValue) {
//                                            if(array_key_exists($valKey, $map[$field][$objKey]) && property_exists($valueObject->{$field}[$internalKey]->{$objKey}[$key], $valKey)) {
//                                                if(!is_array($valValue)) {
//                                                    $proper[$map[$field][$objKey][$valKey]] = $valValue;
//                                                }
//                                            }
//                                        }
//                                        $prop[$objKey][] = (object)$proper;
//                                    }
//                                } else {
//                                    if($objKey === 'price') {
//                                        $objValue = floatval($objValue);
//                                    }
//                                    $prop[$map[$field][$objKey]] = $objValue;
//                                }
//                            }
//                        }
//                        $product[$property][] = (object)$prop;
//                    }
//                } else {
//                    $product[$map[$field]] = $value;
//                }
//            }
//        }
        foreach ($valueObject as $field => $value) {
            if(array_key_exists($field, $map) && property_exists($valueObject, $field)) {
                $property = $field;
                if($field === 'variantsAttributes')
                    $property = 'variants_attributes';
                if(is_array($value) && count($value)) {
                    $i = 0;
                    foreach ($value as $val) {
                        $prop = [];
                        foreach ($val as $k => $v) {
                            if(array_key_exists($k, $map[$field]) && property_exists($valueObject->{$field}[$i], $k)) {
                                if($k === 'price')
                                    $v = floatval($v);
                                $prop[$map[$field][$k]] = $v;
                            }
                        }
                        $i++;
                        $product[$property][] = (object)$prop;
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
        foreach ($data as $field => $value) {
            $checkField = $field;
            if($field === 'variants') {
                $checkField = 'variantsAttributes';
            }
            if(array_key_exists($field, $map) && property_exists($product, is_array($map[$field]) ? $checkField : $map[$field])) {
                if(is_array($value)) {
                    $property = null;
                    foreach ($value as $collection) {
                        if ($field === 'variants') {
                            $property = new Variant();
                        }
                        if($property) {
                            foreach ($collection as $key => $val) {
                                if(array_key_exists($key, $map[$field]) && property_exists($property, $map[$field][$key])) {
                                    $property->{$map[$field][$key]} = $val;
                                }
                            }
                            $product->{$checkField}[] = $property;
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
            if($field === 'variants') {
                $checkField = 'variantsAttributes';
            } else if ($field === 'features') {
                $checkField = 'options';
            }
            if(array_key_exists($field, $map) && property_exists($product, is_array($map[$field]) ? $checkField : $map[$field])) {
                if ($value instanceof Collection) {
                    if($field === 'variants') {
                        if(count($value)) {
                            $property = new Variant();
                            foreach ($value->first() as $key => $val) {
//                                $checkKey = $key;
//                                if ($key === 'features') {
//                                    $checkKey = 'options';
//                                }
//                                if(array_key_exists($key, $map[$field]) && property_exists($property, is_array($map[$field][$key]) ? $checkKey : $map[$field][$key])) {
//                                    if ($val instanceof Collection) {
//                                        $prop = null;
//                                        foreach ($val as $collection) {
//                                            if($key === 'features') {
//                                                $prop = new Option();
//                                                unset($prop->type);
//                                            }
//                                            foreach ($collection as $_key => $_val) {
//                                                if(array_key_exists($_key, $map[$field][$key]) && property_exists($prop, $map[$field][$key][$_key])) {
//                                                    $prop->{$map[$field][$key][$_key]} = $_val;
//                                                }
//                                            }
//                                        }
//                                        $property->{$checkKey}[] = $prop;
//                                    } elseif(empty($val)) {
//                                        if($key === 'title' || $key === 'sku' || $key === 'price' || $key === 'salePrice' || $key === 'quantity') {
//                                            $property->{$map[$field][$key]} = $internalEntity->{$key};
//                                        } elseif ($key === 'productId') {
//                                            $property->{$map[$field][$key]} = empty($internalEntity->id) ? null : (integer)$internalEntity->id;
//                                        }
//                                    } else {
//                                        if ($key === 'id'|| $key === 'productId') {
//                                            $property->{$map[$field][$key]} = (integer)$val;
//                                        } else {
//                                            $property->{$map[$field][$key]} = $val;
//                                        }
//                                    }
//                                }
                                if(array_key_exists($key, $map[$field]) && property_exists($property, $map[$field][$key])) {
                                    if(empty($val)) {
                                        if($key === 'title' || $key === 'sku' || $key === 'price' || $key === 'salePrice' || $key === 'quantity') {
                                            $property->{$map[$field][$key]} = $internalEntity->{$key};
                                        } elseif ($key === 'productId') {
                                            $property->{$map[$field][$key]} = empty($internalEntity->id) ? null : (integer)$internalEntity->id;
                                        }
                                    } else {
                                        if ($key === 'id'|| $key === 'productId') {
                                            $property->{$map[$field][$key]} = (integer)$val;
                                        } else {
                                            $property->{$map[$field][$key]} = $val;
                                        }
                                    }
                                }
                            }
                            if(count($value)) {
//                                $product->extra[$field] = json_decode(json_encode($value->skip(1)), true);
                                $product->extra[$field] = json_decode(json_encode($value), true);
                            }
                            $product->{$checkField}[] = $property;
                        }
                    } elseif ($field === 'features') {
                        $product->extra[$field] = json_decode(json_encode($value), true);
                    } else {
                        $property = null;
                        foreach ($value as $collection) {
                            if ($field === 'images') {
                                $property = new Image();
                            }
                            foreach ($collection as $key => $val) {
                                if(array_key_exists($key, $map[$field]) && property_exists($property, $map[$field][$key])) {
                                    $property->{$map[$field][$key]} = $val;
                                }
                            }
                        }
                        if($property) {
                            $product->{$checkField}[] = $property;
                        }
                    }
                } elseif($field === 'id') {
                    $product->{$map[$field]} = empty($value) ? null : (integer)$value;
                } else {
                    $product->{$map[$field]} = $value;
                }
            } elseif ($field === 'categories') {
                $product->extra[$field] = $value;
            }
        }
        if(empty($product->variantsAttributes)) {
            $product->variantsAttributes[] = new Variant();
            foreach ($internalEntity as $field => $value) {
                $variant = $map['variants'];
                if(array_key_exists($field, $variant)) {
                    $mapField = $variant[$field];
                    if(empty($product->variantsAttributes[0]->{$mapField})) {
                        $product->variantsAttributes[0]->{$mapField} = $value;
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
            if($field === 'variantsAttributes') {
                $checkField = 'variants';
            }
            if(array_key_exists($field, $map) && property_exists($product, is_array($map[$field]) ? $checkField : $map[$field])) {
                if(is_array($value)) {
                    $property = null;
                    $i = 0;
                    foreach ($value as $collection) {
                        $property = null;
                        if ($field === 'variantsAttributes') {
                            $property = new CoreProductVariant();
                        }
                        if($property) {
                            foreach ($collection as $key => $val) {
                                if(array_key_exists($key, $map[$field]) && property_exists($property, $map[$field][$key])) {
                                    $property->{$map[$field][$key]} = $val;
                                    if($field === 'variantsAttributes' && !$i) {
                                        if($key === 'sku' || $key === 'barcode' || $key === 'price' || $key === 'available' || $key === 'quantity' || $key === 'available') {
                                            $product->{$map[$field][$key]} = $val;
                                        }
                                    }
                                }
                            }
                            $product->{$checkField}[] = $property;
                            $i++;
                        }
                    }
                } else {
                    $product->{$map[$field]} = $value;
                }
            }
        }
        if(count($product->variants)) {
            $product->variants[0]->slug = $data->permalink;
            $product->variants[0]->title = $data->title;
        }
        return $product;
    }
}
