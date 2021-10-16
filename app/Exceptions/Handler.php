<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Throwable $exception
     *
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request
     * @param Throwable $exception
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        $errors = [];

        if ($exception instanceof UnauthorizedHttpException) {
            $status = Response::HTTP_UNAUTHORIZED;
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            $status = Response::HTTP_METHOD_NOT_ALLOWED;
            $exception = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $exception);
        } elseif ($exception instanceof NotFoundHttpException) {
            $status = Response::HTTP_NOT_FOUND;
            $exception = new NotFoundHttpException('HTTP_NOT_FOUND', $exception);
        } elseif ($exception instanceof AuthorizationException) {
            $status = Response::HTTP_FORBIDDEN;
            $exception = new AuthorizationException($exception->getMessage() ?: 'HTTP_FORBIDDEN', $status);
        } elseif ($exception instanceof ValidationException && $exception->getResponse()) {
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            $errors = json_decode($exception->getResponse()->getContent(), true);
            $exception = new UnprocessableEntityHttpException($exception->getMessage());
        } elseif ($exception instanceof BadCredentials) {
            $status = $exception->getStatus();
            $exception = new UnprocessableEntityHttpException($exception->getMessage());
        } else {
            return parent::render($request, $exception);
        }

        $response = [
            'status'  => $status,
            'message' => $exception->getMessage()
        ];

        if (count($errors)) {
            $response = array_merge($response, ['errors' => $errors]);
        }

        if ('local' == env('APP_ENV')) {
            $response =array_merge($response, ['trace'   => $exception->getTrace()]);
        }

        return new JsonResponse($response, $status);
    }
}
