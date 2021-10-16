<?php

namespace App\DataProvider\InSales\Api\Option;

use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\OptionValueFactory;
use Throwable;

/**
 * Class PushOptionValue
 * @package App\DataProvider\InSales\Api\Option
 */
final class PushOptionValue extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    protected $path = 'option_names/#{id}/option_values.json';

    /**
     * @return void
     */
    public function changePath()
    {
        $this->path = str_replace('#{id}', $this->id, $this->path);
    }

    /**
     * @return array
     */
    public function handler(): array
    {
        $this->changePath();
        $this->body = OptionValueFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
