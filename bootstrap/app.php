<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable (function (Throwable $exception) {
            $previous = $exception->getPrevious();
            if($previous instanceof ModelNotFoundException) {
                $fullModel = $previous->getModel();

                $model = str($fullModel)->after ('Models\\');

                return  response()->json([
                    'success' => false,
                    'message' => $model . ' not found',
                ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof AuthenticationException) {
                return  response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                ], Response::HTTP_UNAUTHORIZED);
            }

            if ($exception instanceof AccessDeniedHttpException) {
                return  response()->json([
                    'success' => false,
                    'message' => 'Forbidden',
                ], Response::HTTP_FORBIDDEN);
            }

            if ($exception instanceof HttpExceptionInterface) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage() ?: 'HTTP error',
                    'errors' => [],
                ], $exception->getStatusCode());
            }

        });
    })->create();
