<?php

namespace App\DataProvider\Horoshop\Api\Category;

use App\DataProvider\Horoshop\Api\Request;
use App\Http\Client\Response\HttpResponseInterface;

class PushCategory
{
    /**
     * Execute Request
     *
     * @return HttpResponseInterface
     */
    public function execute(): HttpResponseInterface
    {
        $this->initRequest();
        $this->setMethod('GET');
        $this->setPath('/catalog/import/');
        $this->setBody(['products' => []]); //TODO array from Collection DTO

        return parent::execute();
    }
}
