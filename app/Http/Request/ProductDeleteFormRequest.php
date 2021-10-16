<?php

namespace App\Http\Request;

/**
 * Class ProductFormRequest
 * @package App\Http\Request
 */
class ProductDeleteFormRequest extends AbstractFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id'  => 'required',
            'chanel' => 'required|min:2|max:30'
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
