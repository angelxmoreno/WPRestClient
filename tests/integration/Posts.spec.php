<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

use Cake\Core\Configure;
use WPRestClient\Auth\BasicAuth;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\RepositoryRegistry;
use WPRestClient\Entity\PostEntity;
use WPRestClient\Repository\PostsRepository;

Configure::write('debug', true);
describe(PostsRepository::class, function () {
    beforeAll(function () {
        $baseUri = env('WP_DNM', '');
        $username = env('WP_USER', '');
        $password = env('WP_PWD', '');
        $auth = new BasicAuth($username, $password);
        $guzzle = new GuzzleHttp\Client([
            'verify' => false,
        ]);

        $client = new ApiClient($baseUri, $guzzle, $auth);
        $this->registry = new RepositoryRegistry($client);
    });
    describe('::fetch()', function () {
        it('returns PostEntities', function () {
            /** @var PostEntity[] $results */
            $results = $this->registry->posts()::fetch();
            expect($results)->toBeAn('array');
            foreach ($results as $result) {
                expect($result)->toBeAnInstanceOf(PostEntity::class);
                expect($result->getId())->toBeAn('int');
                expect($result->getTitle())->toBeA('string');
            }
        });
    });

    describe('::get()', function () {
        it('returns a PostEntity', function () {
            /** @var PostEntity[] $results */
            $results = $this->registry->posts()::fetch();
            $id = current($results)->getId();

            /** @var PostEntity $result */
            $result = $this->registry->posts()::get($id);

            expect($result)->toBeAnInstanceOf(PostEntity::class);
            expect($result->getId())->toBeAn('int');
            expect($result->getId())->toBe($id);
            expect($result->getTitle())->toBeA('string');
        });
    });

    describe('::save()', function () {
        describe('when creating', function () {
            it('returns a PostEntity', function () {
                $data = [
                    'title' => 'Example Post Title create' . time(),
                ];
                $entity = new PostEntity($data);
                /** @var PostEntity $result */
                $result = $this->registry->posts()::save($entity);
                expect($result)->toBeAnInstanceOf(PostEntity::class);
                expect($result->getId())->toBeAn('int');
                expect($result->getTitle())->toBeA('string');
                expect($result->getTitle())->toBe($data['title']);
            });
        });

        describe('when updating', function () {
            it('returns a PostEntity', function () {
                $data = [
                    'title' => 'Example Post Title update' . time(),
                ];

                $entity = new PostEntity($data);
                /** @var PostEntity $result */
                $result = $this->registry->posts()::save($entity);
                $result->setTitle($data['title'] . ' modified');

                $result = $this->registry->posts()::save($result);

                expect($result)->toBeAnInstanceOf(PostEntity::class);
                expect($result->getId())->toBeAn('int');
                expect($result->getTitle())->toBeA('string');
                expect($result->getTitle())->toBe($data['title'] . ' modified');
            });
        });
    });

    describe('::delete()', function () {
        it('deletes a post remotely', function () {
            $data = [
                'title' => 'Example Post Title delete' . time(),
            ];
            $entity = new PostEntity($data);

            /** @var PostEntity $created */
            $created = $this->registry->posts()::save($entity);
            $id = $created->getId();
            expect($created)->toBeAnInstanceOf(PostEntity::class);

            /** @var PostEntity[] $results */
            $found = $this->registry->posts()::get($id);
            expect($found)->toBeAnInstanceOf(PostEntity::class);

            /** @var PostEntity[] $results */
            $deleted = $this->registry->posts()::delete($found);
            expect($deleted)->toContainKey('id');
            expect($deleted['id'])->toBe($id);
        });
    });
});
