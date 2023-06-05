<?php

/** @noinspection PhpUndefinedMethodInspection */

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use WPRestClient\Core\ApiClient;
use WPRestClient\Entity\PostEntity;
use WPRestClient\Repository\PostsRepository;
use WPRestClient\Test\Helpers\Fixture;
use WPRestClient\Test\Helpers\GuzzleMockBuilder;

describe(PostsRepository::class, function () {
    describe('::get()', function () {
        it('returns a PostEntity', function () {
            $data = Fixture::load('post');
            $httpClient = GuzzleMockBuilder::withResponse(json_encode($data));
            $apiClient = new ApiClient('https://example.wp.com', $httpClient);
            PostsRepository::setApiClient($apiClient);

            $entity = PostsRepository::get(1);
            expect($entity)->toBeAnInstanceOf(PostEntity::class);
            expect($entity->getId())->toBe($data['id']);
            expect($entity->getTitle())->toBe($data['title']['rendered']);
        });
    });

    describe('::fetch()', function () {
        it('returns PostEntity[]', function () {
            $data = Fixture::load('posts');
            $httpClient = GuzzleMockBuilder::withResponse(json_encode($data));
            $apiClient = new ApiClient('https://example.wp.com', $httpClient);
            PostsRepository::setApiClient($apiClient);

            $entities = PostsRepository::fetch();
            expect($entities)->toBeAn('array');
            foreach ($entities as $index => $entity) {
                expect($entity)->toBeAnInstanceOf(PostEntity::class);
                expect($entity->getId())->toBe($data[$index]['id']);
                expect($entity->getTitle())->toBe($data[$index]['title']['rendered']);
            }
        });
    });
});
