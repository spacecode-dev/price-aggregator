<?php

namespace App\Http\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

/**
 * Class AbstractFormRequest
 * @package App\Http\Request
 */
abstract class AbstractFormRequest
{
    use ProvidesConvenienceMethods;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Validator
     */
    public $validator;

    /**
     * AbstractFormRequest constructor.
     * @param Request $request
     * @throws ValidationException
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->handle();
    }

    /**
     * @return void
     * @throws ValidationException
     */
    private function handle(): void
    {
        $this->validate($this->request, $this->rules(), $this->messages());
    }

    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @return array
     */
    abstract public function messages(): array;
}
