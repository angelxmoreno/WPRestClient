<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Cake\Collection\Collection;
use WPRestClient\Core\MemoizedTrait;
use WPRestClient\Test\Sample\SamplesRepository;

describe(MemoizedTrait::class, function () {
    describe('::getMemoize', function () {
        it('returns null when data is not previously memoized', function () {
            $object = new SamplesRepository();
            $reflection = new ReflectionClass($object);
            $getMemoize = $reflection->getMethod('getMemoize');
            $getMemoize->setAccessible(true);
            $result = $getMemoize->invoke($object, 123);
            expect($result)->toBeNull();
        });

        it('returns previously memoized data', function () {
            $data = [
                'id' => 123,
                'name' => 'Some Name',
            ];
            $object = new SamplesRepository();
            $reflection = new ReflectionClass($object);

            $addMemoize = $reflection->getMethod('addMemoize');
            $addMemoize->setAccessible(true);
            $addMemoize->invoke($object, $data);

            $getMemoize = $reflection->getMethod('getMemoize');
            $getMemoize->setAccessible(true);
            $result = $getMemoize->invoke($object, 123);

            expect($result)->toBe($data);
        });
    });

    describe('::addBatchMemoize', function () {
        it('adds batches of data to be memoized', function () {
            $data = [
                ['id' => 123, 'name' => 'Some Name'],
                ['id' => 456, 'name' => 'Some Other Name'],
            ];
            $object = new SamplesRepository();
            $reflection = new ReflectionClass($object);

            $addBatchMemoize = $reflection->getMethod('addBatchMemoize');
            $addBatchMemoize->setAccessible(true);
            $addBatchMemoize->invoke($object, $data);

            $getMemoize = $reflection->getMethod('getMemoize');
            $getMemoize->setAccessible(true);

            $result1 = $getMemoize->invoke($object, 123);
            $result2 = $getMemoize->invoke($object, 456);

            expect($result1)->toBe($data[0]);
            expect($result2)->toBe($data[1]);
        });
    });

    describe('::removeMemoize', function () {
        it('removes memoized data', function () {
            $data = [
                ['id' => 123, 'name' => 'Some Name'],
                ['id' => 456, 'name' => 'Some Other Name'],
            ];
            $object = new SamplesRepository();
            $reflection = new ReflectionClass($object);

            $addBatchMemoize = $reflection->getMethod('addBatchMemoize');
            $addBatchMemoize->setAccessible(true);
            $addBatchMemoize->invoke($object, $data);

            $getMemoize = $reflection->getMethod('getMemoize');
            $getMemoize->setAccessible(true);

            $removeMemoize = $reflection->getMethod('removeMemoize');
            $removeMemoize->setAccessible(true);

            $result1 = $getMemoize->invoke($object, 123);
            $result2 = $getMemoize->invoke($object, 456);

            expect($result1)->toBe($data[0]);
            expect($result2)->toBe($data[1]);

            $removeMemoize->invoke($object, 123);
            $result1 = $getMemoize->invoke($object, 123);
            expect($result1)->toBeNull();
        });
    });

    describe('::getMemoizedCollection()', function () {
        it('returns a ' . Collection::class, function () {
            $data = [
                ['id' => 456, 'name' => 'Some Other Name'],
                ['id' => 123, 'name' => 'Some Name'],
            ];

            $object = new SamplesRepository();
            $reflection = new ReflectionClass($object);

            $addBatchMemoize = $reflection->getMethod('addBatchMemoize');
            $addBatchMemoize->setAccessible(true);
            $addBatchMemoize->invoke($object, $data);

            $getMemoizedCollection = $reflection->getMethod('getMemoizedCollection');
            $getMemoizedCollection->setAccessible(true);

            /** @var Collection $result */
            $result = $getMemoizedCollection->invoke($object);

            expect($result)->toBeAnInstanceOf(Collection::class);
            expect($result->toArray())->toBe([
                $data[0]['id'] => $data[0],
                $data[1]['id'] => $data[1],
            ]);
        });
    });
});
