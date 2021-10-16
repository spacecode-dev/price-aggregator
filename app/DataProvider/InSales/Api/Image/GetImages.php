<?php

namespace App\DataProvider\InSales\Api\Image;

use App\DataProvider\InSales\Api\InSalesApi;
use Throwable;

/**
 * Class GetImages
 * @package App\DataProvider\InSales\Api\Image
 */
final class GetImages extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = 'products/#{id}/images.json';

    /**
     * @var integer
     */
    public $id;

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
        $this->body = [];
        try {
            $response = $this->buildRequest()->execute();
            return $this->toArray($response);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
