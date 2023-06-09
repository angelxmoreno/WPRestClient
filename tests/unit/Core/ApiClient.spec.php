<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Kahlan\Plugin\Double;
use Psr\Http\Message\RequestInterface;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\ApiResponseException;
use WPRestClient\Core\AuthInterface;
use WPRestClient\Test\Helpers\ExceptionBuilder;
use WPRestClient\Test\Helpers\GuzzleMockBuilder;

describe(ApiClient::class, function () {
    describe('->sendRequest()', function () {
        it('returns an array', function () {
            $httpClient = GuzzleMockBuilder::withFixture('users');
            $api = new ApiClient('https://example.wp.com', $httpClient);
            $data = $api->sendRequest('get', '/users/');
            expect($data)->toBeAn('array');
        });

        it('uses auth when passed', function () {
            /** @var AuthInterface $auth */
            $auth = Double::instance([
                'implements' => AuthInterface::class,
            ]);
            allow($auth)->toReceive('withAuth')->andRun(function (RequestInterface $request) {
                return $request->withAddedHeader('WillAuth', 'DidAuth');
            });
            $httpClient = GuzzleMockBuilder::withFixture('users');
            $api = new ApiClient('https://example.wp.com', $httpClient);
            $api->setAuth($auth);

            expect($auth)->toReceive('withAuth')->once();
            $data = $api->sendRequest('get', '/users/');
            expect($data)->toBeAn('array');
        });

        it('throws an exception on server error', function () {
            $httpClient = GuzzleMockBuilder::withFixture('users');
            $clientException = ExceptionBuilder::clientException();
            allow($httpClient)->toReceive('send')->andRun(function () use ($clientException) {
                throw $clientException;
            });
            $api = new ApiClient('https://example.wp.com', $httpClient);
            expect(function () use ($api) {
                $api->sendRequest('get', '/users/');
            })->toThrow(new ApiResponseException($clientException->getMessage(), $clientException->getCode()));
        });
    });
});
