<?php

namespace App\Exceptions;

use App\GamesRequestsDirectory\Responses\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        AuthenticationException::class,
        NotFoundHttpException::class,
        TokenMismatchException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    public function report(Throwable $e): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        parent::report($e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //$this->reportable(function (Throwable $e) {
            //
       // });
    }
    protected function prepareJsonResponse($request, Throwable $e): JsonResponse|\Illuminate\Http\JsonResponse
    {
        return JsonResponse::exception($e);
    }

    protected function invalidJson($request, ValidationException $exception): JsonResponse|\Illuminate\Http\JsonResponse
    {
        return JsonResponse::exception($exception);
    }
}
