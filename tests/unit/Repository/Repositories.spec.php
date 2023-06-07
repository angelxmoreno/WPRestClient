<?php

/** @noinspection PhpUndefinedMethodInspection */

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Cake\Utility\Inflector;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\RepositoryRegistry;
use WPRestClient\Test\Helpers\Fixture;
use WPRestClient\Test\Helpers\GuzzleMockBuilder;

describe('Repositories', function () {
    given('registry', function () {
        $httpClient = GuzzleMockBuilder::withResponse('[]');
        $api = new ApiClient('https://example.wp.com', $httpClient);
        return new RepositoryRegistry($api);
    });

    $aliases = $this->registry->getAliases();
    foreach ($aliases as $alias) {
        describe($this->registry->getRepository($alias), function () use ($alias) {
            describe('::get()', function () use ($alias) {
                it('returns a entity', function () use ($alias) {
                    $repository = $this->registry->getRepository($alias);
                    $data = Fixture::load(Inflector::singularize($alias));
                    $id = $data['id'];
                    $httpClient = GuzzleMockBuilder::withResponse(json_encode($data));
                    $apiClient = new ApiClient('https://example.wp.com', $httpClient);
                    call_user_func([$repository, 'setApiClient'], $apiClient);
                    $entityClass = call_user_func([$repository, 'getEntityClass']);

                    $entity = call_user_func([$repository, 'get'], $id);
                    expect($entity)->toBeAnInstanceOf($entityClass);
                    expect($entity->getId())->toBe($data['id']);
                });
            });

            describe('::fetch()', function () use ($alias) {
                it('returns an array of entity', function () use ($alias) {
                    $repository = $this->registry->getRepository($alias);
                    $plural = $alias === 'media' ? 'medias' : Inflector::pluralize($alias);
                    $data = Fixture::load($plural);

                    $httpClient = GuzzleMockBuilder::withResponse(json_encode($data));
                    $apiClient = new ApiClient('https://example.wp.com', $httpClient);
                    call_user_func([$repository, 'setApiClient'], $apiClient);
                    $entityClass = call_user_func([$repository, 'getEntityClass']);

                    $entities = call_user_func([$repository, 'fetch']);
                    expect($entities)->toBeAn('array');
                    foreach ($entities as $entity) {
                        expect($entity)->toBeAnInstanceOf($entityClass);
                    }
                });
            });
        });
    }
});
