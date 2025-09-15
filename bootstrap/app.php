<?php

use App\Infrastructure\Repositories\Exceptions\TravelOrderRepositoryExceptions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (Throwable $e, \Illuminate\Http\Request $request) {

            $code = match (true) {
                $e instanceof ValidationException => 422,
                $e instanceof TravelOrderRepositoryExceptions => 400,
                $e instanceof AuthenticationException => 401,
                default => 500,
            };

            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'type'    => class_basename($e),
                ], $code);
            }
            return null;
        });
    })->create();
