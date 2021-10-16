<?php

namespace App\DataProvider\Horoshop;

use App\Http\Client\Configuration\AbstractHttpConfiguration;

/**
 * Class Config
 * @package App\DataProvider\Horoshop
 */
final class Config extends AbstractHttpConfiguration
{
    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->setHost('<DOMAIN>/api/');
        $this->setCredentials([]);
    }
}
