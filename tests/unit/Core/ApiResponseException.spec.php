<?php

declare(strict_types=1);

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use WPRestClient\Core\ApiResponseException;
use WPRestClient\Test\Helpers\ExceptionBuilder;

describe(ApiResponseException::class, function () {
    describe('::fromClientException()', function () {
        it('creates an instance of ' . ApiResponseException::class, function () {
            $status = 401;
            $code = 'Not_LoggedIn';
            $message = 'You need to log in';
            $clientException = ExceptionBuilder::clientException($status, $code, $message);
            $apiResponseException = ApiResponseException::fromClientException($clientException);

            expect($apiResponseException)->toBeAnInstanceOf(ApiResponseException::class);
            expect($apiResponseException->getMessage())->toBe($message);
            expect($apiResponseException->getType())->toBe($code);
            expect($apiResponseException->getCode())->toBe($status);
            expect($apiResponseException->getPrevious())->toBe($clientException);
        });
    });
});
