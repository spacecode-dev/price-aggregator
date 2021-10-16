<?php

namespace App\Http\Request;

/**
 * Class ProductFormRequest
 * @package App\Http\Request
 */
class ProductFormRequest extends AbstractFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'chanel' => 'required|min:2|max:30',
            'title' => 'required|string|min:3|max:160',
            'description' => 'string|min:3|max:255',
            'slug' => 'string|min:3|max:160',
            'mpn' => 'string|min:3',
            'sku' => 'required|string|min:3',
            'price' => 'required|string|min:1',
            'salePrice' => 'string|nullable|min:1',
            'vendor' => 'string|nullable|min:3|max:160',
            'images' => 'array',
            'images.*.src' => 'required_with:images|string',
            'images.*.extension' => 'in:jpg,jpeg,png,webp,bmp',
            'images.*.default' => 'boolean',
            'features' => 'array',
            'features.*.key' => 'required_with:features|string',
            'features.*.value' => 'required_with:features|required|array',
//            'shipping' => 'required|array|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'boolean',
            'extra' => 'array',
            'categories' => 'required|array',
            'variants' => 'array',
            'variants.*.title' => 'string|min:3|max:160',
            'variants.*.slug' => 'string|min:3|max:160',
            'variants.*.mpn' => 'string|min:3',
            'variants.*.sku' => 'required_with:variants|string|min:3',
            'variants.*.price' => 'required_with:variants|string|min:1',
            'variants.*.salePrice' => 'string|nullable|min:1',
            'variants.*.images' => 'array',
            'variants.*.images.*.src' => 'required_with:variants.*.images|required|string',
            'variants.*.images.*.extension' => 'in:jpg,jpeg,png,webp,bmp',
            'variants.*.images.*.default' => 'boolean',
            'variants.*.features' => 'array',
            'variants.*.features.*.key' => 'required_with:variants.*.features|string',
            'variants.*.features.*.value' => 'required_with:variants.*.features|string',
//            'variants.*.shipping' => 'required_with:variants|required|array|min:0',
            'variants.*.quantity' => 'required_with:variants|integer|min:0',
            'variants.*.status' => 'boolean'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}
