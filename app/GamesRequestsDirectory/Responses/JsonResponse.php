<?php

namespace App\GamesRequestsDirectory\Responses;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse as Base;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

final class JsonResponse extends Base
{
    public function __construct(int $httpCode, string $description, $payload = null, array $headers = [], int $jsonOptions = 0)
    {
        $data = [
            'description' => $description,
            'payload' => $payload instanceof Arrayable ? $payload->toArray() : $payload,
        ];

        parent::__construct($data, $httpCode, $this->headers($headers), $this->jsonOptions($jsonOptions));
    }

    public static function success($payload = null, int $jsonOptions = 0): self
    {
        return new self(self::HTTP_OK, 'OK', $payload, [], $jsonOptions);
    }

    public static function exception(Throwable $e, array $payload = []): self
    {
        if (self::isValidationException($e)) {
            /** @var ValidationException $e */
            return self::validationException($e);
        }

        if (self::isAuthenticationException($e)) {
            /** @var AuthenticationException $e */
            return new self(401, $e->getMessage());
        }

        $code = 500;
        $headers = [];
        $payload = array_merge(self::convertExceptionToArray($e), $payload);

        if (self::isHttpException($e)) {
            /** @var HttpException $e */
            $code = $e->getStatusCode();
            $headers = $e->getHeaders();
        }

        return new self($code, $payload['message'], $payload, $headers);
    }

    public static function error(
        string $description = 'Server Error',
        int $code = self::HTTP_INTERNAL_SERVER_ERROR,
        array $payload = []
    ): self {
        return self::exception(new HttpException($code, $description), $payload);
    }

    private static function validationException(ValidationException $exception): self
    {
        return new self(
            $exception->status,
            $exception->getMessage(),
            [
                'errors' => $exception->validator->failed(),
                'messages' => $exception->errors(),
            ]
        );
    }

    private static function isHttpException(Throwable $e): bool
    {
        return $e instanceof HttpException;
    }

    private static function isValidationException(Throwable $e): bool
    {
        return $e instanceof ValidationException;
    }

    private static function isAuthenticationException(Throwable $e): bool
    {
        return $e instanceof AuthenticationException;
    }

    private static function convertExceptionToArray(Throwable $e): array
    {
        if (self::shouldBeVerbose()) {
            return [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => Collection::make($e->getTrace())
                    ->map(
                        static function (array $item): array {
                            return Arr::except($item, ['args']);
                        }
                    )
                    ->toArray(),
            ];
        }

        return [
            'message' => self::isHttpException($e)
                ? $e->getMessage()
                : 'Server Error',
        ];
    }

    private static function shouldBeVerbose(): bool
    {
        return config('app.debug', false) === true || app()->runningUnitTests();
    }

    public function isOk(): bool
    {
        return $this->statusCode >= self::HTTP_OK && $this->statusCode <= 299;
    }

    private function headers(array $headers): array
    {
        if (!array_key_exists('Content-Type', $headers)) {
            // Стандартный ответ не устанавливает кодировку и она иногда получается кривой
            $headers['Content-Type'] = 'application/json; charset=utf-8';
        }

        return $headers;
    }

    private function jsonOptions(int $jsonOptions = 0): int
    {
        if (self::shouldBeVerbose() || request()->input('pretty', 'n') === 'y') {
            $jsonOptions = $jsonOptions | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
        }

        return $jsonOptions | self::DEFAULT_ENCODING_OPTIONS;
    }

}
