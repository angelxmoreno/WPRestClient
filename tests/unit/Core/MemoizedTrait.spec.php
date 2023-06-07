<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

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
});