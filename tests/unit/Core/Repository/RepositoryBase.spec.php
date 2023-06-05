<?php

declare(strict_types=1);

use WPRestClient\Core\Entity\EntityBase;
use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\PostEntity;
use WPRestClient\Repository\PostsRepository;
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
});
