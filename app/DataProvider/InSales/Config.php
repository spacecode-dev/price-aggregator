<?php

namespace App\DataProvider\InSales;

use App\Http\Client\Configuration\AbstractHttpConfiguration;
use App\Http\Client\Configuration\HttpConfigurationInterface;

/**
 * Class Config
 * @package App\DataProvider\Horoshop
 */
final class Config extends AbstractHttpConfiguration
{
    private static $instance = null;

    /**
     * Config constructor.
     *
     * InSales api 'https://api.insales.ru/?doc_format=JSON'
     */
    private function __construct()
    {
        $this->setHost(env('INSALES_URL') . '/admin');
    }

    /**
     * @return static
     */
    public static function init(): HttpConfigurationInterface
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
