<?php

namespace App\DataProvider\InSales\Api\Option;

use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\OptionNameFactory;
use Throwable;

/**
 * Class PushOptionName
 * @package App\DataProvider\InSales\Api\Option
 */
final class PushOptionName extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $path = 'option_names.json';

    /**
     * @return array
     */
    public function handler(): array
    {
        $this->body = OptionNameFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
