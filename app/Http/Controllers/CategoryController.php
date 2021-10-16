<?php

namespace App\Http\Controllers;

use App\Core\Entity\Category;
use App\DataProvider\DataProviderApiInterface;
use App\DataProvider\FactoryInterface;
use App\DataProvider\ServiceResolver;
use App\Http\Request\CategoryDeleteFormRequest;
use App\Http\Request\CategoryFormRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    use ServiceResolver;

    /**
     * @param CategoryFormRequest $request
     *
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function upload(CategoryFormRequest $request): JsonResponse
    {
        $chanel = $request->request->get('chanel');
        $action = $request->request->has('id') ? 'put' : 'push';

        $internalEntity = $this->processRequest(new Category(), $request->request->all());

        $dataProvider = $this->findServiceByName($chanel, 'collection', $action);

        /** @var FactoryInterface $dataProviderFactory */
        $dataProviderFactory = $this->findFactoryByChanel($chanel, 'collection');

        /** @var DataProviderApiInterface $dataProviderConnection */
        $dataProviderConnection = new $dataProvider();
        $dataProviderConnection->setProviderEntity($dataProviderFactory::modifyRequest($internalEntity));
        $response = $dataProviderFactory::modifyResponse($dataProviderConnection->handler());

        return JsonResponse::create($response, Response::HTTP_OK);
    }

    /**
     * @param CategoryDeleteFormRequest $request
     *
     * @return JsonResponse
     */
    public function delete(CategoryDeleteFormRequest $request): JsonResponse
    {
        $dataProvider = $this->findServiceByName($request->request->get('chanel'), 'collection', 'delete');

        /** @var DataProviderApiInterface $dataProviderConnection */
        $dataProviderConnection = new $dataProvider();
        $dataProviderConnection->id = $request->request->get('id');
        $response = $dataProviderConnection->handler();

        return JsonResponse::create($response, Response::HTTP_OK);
    }
}
