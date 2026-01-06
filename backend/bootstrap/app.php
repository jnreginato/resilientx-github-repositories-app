<?php

use App\Exceptions\GitHubRateLimitException;
use App\Exceptions\GitHubSearchLimitException;
use App\Exceptions\GitHubUnavailableException;
use App\Exceptions\RepositoryNotFoundException;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->group('api', [ForceJsonResponse::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (RepositoryNotFoundException $e): JsonResponse {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        });
        $exceptions->renderable(function (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });
        $exceptions->renderable(function (GitHubSearchLimitException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });
        $exceptions->renderable(function (GitHubRateLimitException $e): JsonResponse {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_TOO_MANY_REQUESTS);
        });
        $exceptions->renderable(function (GitHubUnavailableException $e): JsonResponse {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        });
    })->create();
