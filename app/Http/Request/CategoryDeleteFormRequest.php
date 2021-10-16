<?php

namespace App\Http\Request;

/**
 * Class CategoryDeleteFormRequest
 * @package App\Http\Request
 */
class CategoryDeleteFormRequest extends AbstractFormRequest
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
