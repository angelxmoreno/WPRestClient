<?php

/** @noinspection PhpUndefinedMethodInspection */

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Kahlan\Plugin\Double;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Core\RepositoryRegistry;
use WPRestClient\Repository\PostsRepository;
use WPRestClient\Test\Helpers\GuzzleMockBuilder;

describe(RepositoryRegistry::class, function () {
    given('registry', function () {
        $httpClient = GuzzleMockBuilder::withResponse('{}');
        $api = new ApiClient('https://example.wp.com', $httpClient);
        return new RepositoryRegistry($api);
    });

    describe('->getRepository()', function () {
        it('returns ' . PostsRepository::class, function () {
            expect($this->registry->posts())->toBe(PostsRepository::class);
            expect(function () {
                $this->registry->post();
            })->toThrow(new RuntimeException());
        });
    });

    describe('->getAliases()', function () {
        it('returns the array of alias name', function () {
            $reflection = new ReflectionProperty(RepositoryRegistry::class, 'repositories');
            $reflection->setAccessible(true);
            $repositories = $reflection->getValue($this->registry);
            $actual = $this->registry->getAliases();
            expect($actual)->toBeAn('array');
            expect($actual)->toBe(array_keys($repositories));
        });
    });

    describe('->addRepository()', function () {
        describe('when the class does not exist', function () {
            it('throws an exception', function () {
                $className = 'Foo';
                $message = sprintf('%s cannot be found', $className);
                expect(function () use ($className) {
                    $this->registry->addRepository($className, 'foo');
                })->toThrow(new UnexpectedValueException($message));
            });
        });

        describe('when the class is not a subclass of ' . RepositoryBase::class, function () {
            it('throws an exception', function () {
                $className = Double::classname();
                $message = sprintf('%s is not a child class of %s', $className, RepositoryBase::class);
                expect(function () use ($className) {
                    $this->registry->addRepository($className, 'foo');
                })->toThrow(new UnexpectedValueException($message));
            });
        });

        describe('when the class is a subclass of ' . RepositoryBase::class, function () {
            it('registers the repository', function () {
                $className = Double::classname([
                    'extends' => RepositoryBase::class,
                ]);
                $this->registry->addRepository($className, 'foo');
                expect($this->registry->foo())->toBe($className);
            });
        });
    });
});
