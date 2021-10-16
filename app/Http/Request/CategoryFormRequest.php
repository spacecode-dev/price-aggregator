<?php

namespace App\Http\Request;

/**
 * Class CategoryFormRequest
 * @package App\Http\Request
 */
class CategoryFormRequest extends AbstractFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'chanel' => 'required|min:2|max:30',
            'title'  => 'required|min:4|max:200',
            'status' => 'boolean',
            'extra'  => 'array',
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
