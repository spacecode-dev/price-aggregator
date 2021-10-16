<?php

namespace App\DataProvider\InSales\Api\Image;

use App\DataProvider\DataProviderEntityInterface;
use App\DataProvider\InSales\Api\InSalesApi;
use App\DataProvider\InSales\Factory\ImageFactory;
use Throwable;

/**
 * Class PushImageBySrc
 * @package App\DataProvider\InSales\Api\Image
 */
final class PushImageBySrc extends InSalesApi
{
    /**
     * @var string
     */
    protected $method = 'POST';

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
     * @return DataProviderEntityInterface
     */
    public function handler(): DataProviderEntityInterface
    {
        $this->changePath();
        $this->body = ImageFactory::toRequest($this->providerEntity);
        try {
            $response = $this->buildRequest()->execute();
            return ImageFactory::fromRequest($this->toArray($response));
        } catch (Throwable $exception) {
            dd($exception);
        }
    }
}
