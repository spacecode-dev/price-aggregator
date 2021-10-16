<?php

namespace App\Http\Controllers;

use App\Core\InternalEntityInterface;
use App\Core\ObjectPropertyBuilder;
use App\Exceptions\BadCredentials;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use ObjectPropertyBuilder;

    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /** @var JWTAuth */
    protected $tokenStorage;

    /**
     * Controller constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param JWTAuth         $tokenStorage
     */
    public function __construct(DatabaseManager $databaseManager, JWTAuth $tokenStorage)
    {
        $this->databaseManager = $databaseManager;
        $this->tokenStorage    = $tokenStorage;
    }

    /**
     * @param array  $credentials
     * @param string $expire
     *
     * @return string
     * @throws BadCredentials
     */
    protected function generateToken(array $credentials, string $expire): string
    {
        $payload = [
            'iat' => time(), // Time when JWT was issued.
            'exp' => Carbon::now()->addDays($expire)->timestamp // Expiration time
        ];

        $this->tokenStorage->customClaims($payload);
        $token = $this->tokenStorage->attempt($credentials);
        if (!$token) {
            throw new BadCredentials('Given login or password not valid');
        }
        $this->tokenStorage->setToken($token);

        return $token;
    }

    /**
     * @param array $data
     * @param int   $status
     *
     * @return JsonResponse
     */
    protected function toJson(array $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    /**
     * Set data from Request content into InternalEntityInterface object.
     *
     * @param InternalEntityInterface $entity
     * @param array $data
     *
     * @return InternalEntityInterface
     * @throws \ReflectionException
     */
    protected function processRequest(InternalEntityInterface $entity, array $data): InternalEntityInterface
    {
        if (false == count($data)) {
            throw new BadRequestHttpException('Data can\'t be empty');
        }

        return $this->fillEntity($entity, $data);
    }
}
