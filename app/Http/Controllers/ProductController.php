<?php

namespace App\Http\Controllers;

use App\Core\Entity\Product;
use App\DataProvider\DataProviderApiInterface;
use App\DataProvider\FactoryInterface;
use App\DataProvider\ServiceResolver;
use App\Http\Request\ProductDeleteFormRequest;
use App\Http\Request\ProductFormRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    use ServiceResolver;

    /**
     * @param ProductFormRequest $request
     *
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function upload(ProductFormRequest $request): JsonResponse
    {
        $chanel = $request->request->get('chanel');
        $action = $request->request->has('id') ? 'put' : 'push';

        $internalEntity = $this->processRequest(new Product(), $request->request->all());

        $dataProvider = $this->findServiceByName($chanel, 'product', $action);

        /** @var FactoryInterface $dataProviderFactory */
        $dataProviderFactory = $this->findFactoryByChanel($chanel, 'product');

        /** @var DataProviderApiInterface $dataProviderConnection */
        $dataProviderConnection = new $dataProvider();
        $dataProviderConnection->setProviderEntity($dataProviderFactory::modifyRequest($internalEntity));
        $response = $dataProviderFactory::modifyResponse($dataProviderConnection->handler());

        return JsonResponse::create($response, Response::HTTP_OK);
    }

    /**
     * @param ProductDeleteFormRequest $request
     *
     * @return JsonResponse
     */
    public function delete(ProductDeleteFormRequest $request): JsonResponse
    {
        $dataProvider = $this->findServiceByName($request->request->get('chanel'), 'product', 'delete');

        /** @var DataProviderApiInterface $dataProviderConnection */
        $dataProviderConnection = new $dataProvider();
        $dataProviderConnection->id = $request->request->get('id');
        $response = $dataProviderConnection->handler();

        return JsonResponse::create($response, Response::HTTP_OK);
    }
}
