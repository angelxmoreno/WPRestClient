<?php

/** @noinspection PhpUndefinedMethodInspection */

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use WPRestClient\Core\ApiClient;
use WPRestClient\Core\Entity\EntityBase;
use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\PostEntity;
use WPRestClient\Repository\PostsRepository;
use WPRestClient\Test\Helpers\Fixture;
use WPRestClient\Test\Helpers\GuzzleMockBuilder;
use WPRestClient\Test\Sample\SamplesRepository;

describe(RepositoryBase::class, function () {
    describe('::getPath()', function () {
        describe('when the path is set at the parent', function () {
            it('returns the parent value', function () {
                expect(PostsRepository::getPath())->toBe('posts');
            });
        });

        describe('when the path is not set at the parent', function () {
            it('infers the value', function () {
                expect(SamplesRepository::getPath())->toBe('samples');
            });
        });
    });

    describe('::getEntityClass()', function () {
        describe('when the EntityClass is set at the parent', function () {
            it('returns the parent value', function () {
                expect(PostsRepository::getEntityClass())->toBe(PostEntity::class);
            });
        });

        describe('when the EntityClass is not set at the parent', function () {
            it('infers the value', function () {
                expect(SamplesRepository::getEntityClass())->toBe(EntityBase::class);
            });
        });
    });

    describe('::save', function () {
        describe('when creating', function () {
            it('sends a post request', function () {
                $httpClient = GuzzleMockBuilder::withFixture('post');
                $api = new ApiClient('https://example.wp.com', $httpClient);
                PostsRepository::setApiClient($api);
                $entity = new PostEntity(Fixture::load('post'));
                $entity->setTitle($entity->getTitle() . ' modified');
                $entity->setId(null);
                expect($api)->toReceive('sendRequest')->with('post', 'posts', $entity->jsonSerialize());
                PostsRepository::save($entity);
            });
        });
        describe('when updating', function () {
            it('sends a put request', function () {
                $httpClient = GuzzleMockBuilder::withFixture('post');
                $api = new ApiClient('https://example.wp.com', $httpClient);
                PostsRepository::setApiClient($api);
                $entity = new PostEntity(Fixture::load('post'));
                $newTitle = $entity->getTitle() . ' modified';
                $entity->setTitle($newTitle);
                expect($api)->toReceive('sendRequest')->with('put', 'posts/' . $entity->getId(), [
                    'title' => $newTitle,
                ]);
                PostsRepository::save($entity);
            });
        });
    });

    describe('::delete', function () {
        it('sends a delete request', function () {
            $httpClient = GuzzleMockBuilder::withFixture('post');
            $api = new ApiClient('https://example.wp.com', $httpClient);
            PostsRepository::setApiClient($api);
            $entity = new PostEntity(Fixture::load('post'));
            expect($api)->toReceive('sendRequest')->with('delete', 'posts/' . $entity->getId());
            PostsRepository::delete($entity);
        });
    });
});
