<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            SubstituteBindings::class,
            ThrottleRequests::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ValidationException $exception, Request $request) {
            $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $title = $exception->getMessage();
            $details = $exception->errors();

            $response =  response()->json([
                'http_code' => $httpCode,
                'title' => $title,
                'details' => $details,
                'trace' => $exception->getTrace(),
                'inputs' => $request->input()
            ], $httpCode);

            return $response;
        });
    })->create();
