<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class Authenticate
 * @package App\Http\Middleware
 */
class Authenticate
{
    /**
     * @var JWTAuth
     */
    private $tokenStorage;

    /**
     * Authenticate constructor.
     *
     * @param JWTAuth $tokenStorage
     */
    public function __construct(JWTAuth $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @throws AuthorizationException
     * @throws JWTException
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            throw new UnauthorizedHttpException($request, 'HTTP_UNAUTHORIZED');
        }

        try {
            $this->tokenStorage->setToken($token);
            $this->tokenStorage->checkOrFail();
        } catch (TokenBlacklistedException $e) {
            throw new UnauthorizedHttpException($request, 'HTTP_UNAUTHORIZED');
        } catch (TokenInvalidException $e) {
            throw new AuthorizationException($e->getMessage());
        }

        $user = User::query()->find($this->tokenStorage->getClaim('sub'));

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
