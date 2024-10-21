<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Validation\ValidationException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    ->withExceptions(function (Exceptions $exception) {
        // Validação //
        $exception->renderable(function (ValidationException $exception) {
            $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $title = $exception->getMessage();
            $details = $exception->errors();

            $response =  response()->json([
                'http_code' => $httpCode,
                'title' => $title,
                'details' => $details,
                'trace' => $exception->getTrace(),
            ], $httpCode);

            return $response;
        });

        // 400 //
        $exception->renderable(function (BadRequestHttpException $exception, Request $request) {
            $httpCode = Response::HTTP_BAD_REQUEST;

            $title = 'Recurso não encontrado!';
            $details = ['message' => 'Ocorreu algum erro por parte do cliente'];

            $response =  response()->json([
                'http_code' => $httpCode,
                'title' => $title,
                'details' => $details,
                'trace' => $exception->getTrace(),
                'inputs' => $request->input()
            ], $httpCode);
            return response()->json($response, $httpCode);
        });

        // 404 //
        $exception->renderable(function (NotFoundHttpException $exception) {
            $httpCode = Response::HTTP_NOT_FOUND;

            $title = 'Recurso não encontrado!';
            $details = ['message' => 'Requisição não encontrada '];



            $response =  response()->json([
                'http_code' => $httpCode,
                'title' => $title,
                'details' => $details,
                'trace' => $exception->getTrace(),
            ], $httpCode);

            return response()->json($response, $httpCode);
        });


        // 500 //
        $exception->renderable(function (InternalErrorException $exception) {
            $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;

            $title = 'Condição inesperada!';
            $details = ['message' => 'O servidor encontrou uma condição inesperada que o impediu de atender à solicitação.'];

            $response =  response()->json([
                'http_code' => $httpCode,
                'title' => $title,
                'details' => $details,
                'trace' => $exception->getTrace(),
            ], $httpCode);

            return response()->json($response, $httpCode);
        });
    })->create();
