<?php

declare(strict_types=1);

namespace WPRestClient\Test\Helpers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use WPRestClient\Core\ApiResponseException;

class ExceptionBuilder
{
    public static function apiResponseException(
        int $status = 401,
        string $code = 'some_error',
        string $message = 'Something Wrong happened'
    ): ApiResponseException {
        $clientException = self::clientException($status, $code, $message);
        return ApiResponseException::fromClientException($clientException);
    }

    public static function clientException(
        int $status = 401,
        string $code = 'some_error',
        string $message = 'Something Wrong happened'
    ): ClientException {
        $data = [
            'message' => $message,
            'code' => $code,
            'data' => [
                'status' => $status,
            ],
        ];
        $body = Utils::streamFor(json_encode($data));
        $response = new Response($status, [], $body);
        $request = new Request('post', 'https://example.com');
        return new ClientException($message, $request, $response);
    }
}
