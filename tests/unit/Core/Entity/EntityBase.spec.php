<?php

/** @noinspection PhpUndefinedMethodInspection */

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use WPRestClient\Core\Entity\EntityBase;
use WPRestClient\Test\Sample\SampleEntity;

describe(EntityBase::class, function () {
    it('sets data via its constructor', function () {
        $data = [
            'id' => 123,
            'name' => 'John',
            'age' => DateTime::createFromFormat('Y', '2000'),
            'passed' => true,
        ];

        $expectation = $data;
        $expectation['age'] = date('Y') - 2000;

        $sampleEntity = new SampleEntity($data);
        $reflectionClass = new ReflectionClass($sampleEntity);
        foreach ($expectation as $k => $expected) {
            $property = $reflectionClass->getProperty($k);
            $property->setAccessible(true);
            $actual = $property->getValue($sampleEntity);
            expect($actual)->toBe($expected);
        }
    });

    it('respects existing setters and getters', function () {
        $data = [
            'id' => 123,
            'name' => 'John',
            'age' => DateTime::createFromFormat('Y', '2000'),
            'passed' => true,
        ];

        $sampleEntity = new SampleEntity($data);
        expect($sampleEntity->getPassed())->toBeAn('string');
        expect($sampleEntity->getPassed())->toBe('OK');
        expect($sampleEntity->getAge())->toBeAn('int');
        expect($sampleEntity->getAge())->toBe(date('Y') - 2000);
    });

    it('throws an exception when a bad getter is used', function () {
        $data = [
            'id' => 123,
            'name' => 'John',
            'age' => DateTime::createFromFormat('Y', '2000'),
            'passed' => true,
        ];

        $sampleEntity = new SampleEntity($data);
        $message = sprintf(
            'method "%s" does not exist in class "%s"',
            'getUnknown',
            SampleEntity::class
        );
        expect(function () use ($sampleEntity) {
            $sampleEntity->getUnknown();
        })->toThrow(new RuntimeException($message));
    });

    it('is serializable', function () {
        $expected = $data = [
            'id' => 123,
            'name' => [
                'rendered' => 'John',
            ],
            'age' => DateTime::createFromFormat('Y', '2000'),
            'passed' => true,
        ];

        $expected['name'] = $data['name']['rendered'];
        $expected['age'] = date('Y') - 2000;
        $expected['passed'] = 'OK';

        $sampleEntity = new SampleEntity($data);
        $actual = $sampleEntity->jsonSerialize();
        expect($actual)->toBe($expected);
    });
});
