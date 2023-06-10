<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use GuzzleHttp\Client;
use WPRestClient\Auth\BasicAuth;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\RegistryFactory;
use WPRestClient\Core\RepositoryRegistry;

describe(RegistryFactory::class, function () {
    describe('::basicAuthConnection()', function () {
        it('creates an instance of ' . RepositoryRegistry::class, function () {
            $registry = RegistryFactory::basicAuthConnection('', '', '');
            expect($registry)->toBeAnInstanceOf(RepositoryRegistry::class);
        });

        it(sprintf('uses the %s auth class with credentials', BasicAuth::class), function () {
            $username = 'john';
            $password = 'secret';

            $registry = RegistryFactory::basicAuthConnection('', $username, $password);

            $apiClientProp = new ReflectionProperty($registry, 'apiClient');
            $apiClientProp->setAccessible(true);
            $apiClient = $apiClientProp->getValue($registry);
            $auth = $apiClient->getAuth();
            expect($auth)->toBeAnInstanceOf(BasicAuth::class);
            expect($auth->getUsername())->toBe($username);
            expect($auth->getPassword())->toBe($password);
        });
    });
});
