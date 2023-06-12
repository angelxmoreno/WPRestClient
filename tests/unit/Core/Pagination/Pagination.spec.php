<?php

declare(strict_types=1);

use WPRestClient\Core\Pagination\Pagination;

describe(Pagination::class, function () {
    describe('setters/getters', function () {
        $page = 2;
        $limit = 12;
        $totalItems = 321;
        $pagination = new Pagination($page, $limit, $totalItems);

        $map = [
            'getPage' => $page,
            'getLimit' => $limit,
            'getTotalItems' => $totalItems,
            'getTotalPages' => (int)ceil($totalItems / $limit),
            'hasPrevious' => true,
            'hasNext' => true,
            'previousPage' => $page - 1,
            'nextPage' => $page + 1,
        ];

        foreach ($map as $method => $expected) {
            describe(sprintf('->%s()', $method), function () use ($pagination, $method, $expected) {
                it(sprintf('returns "%s" as expected', $expected), function () use ($pagination, $method, $expected) {
                    expect($pagination->{$method}())->toBe($expected);
                });
            });
        }
    });

    describe('->hasNext()', function () {
        it('returns if there is a next page', function () {
            $pagination = new Pagination(1, 1, 1);
            expect($pagination->hasNext())->toBeFalsy();

            $pagination = new Pagination(10, 1, 1);
            expect($pagination->hasNext())->toBeFalsy();

            $pagination = new Pagination(10, 1, 10);
            expect($pagination->hasNext())->toBeFalsy();

            $pagination = new Pagination(10, 1, 9);
            expect($pagination->hasNext())->toBeFalsy();

            $pagination = new Pagination(9, 1, 10);
            expect($pagination->hasNext())->toBeTruthy();
        });
    });

    describe('->hasPrevious()', function () {
        it('returns if there is a previous page', function () {
            $pagination = new Pagination(1, 1, 1);
            expect($pagination->hasPrevious())->toBeFalsy();

            $pagination = new Pagination(10, 1, 1);
            expect($pagination->hasPrevious())->toBeTruthy();

            $pagination = new Pagination(10, 1, 10);
            expect($pagination->hasPrevious())->toBeTruthy();

            $pagination = new Pagination(10, 1, 9);
            expect($pagination->hasPrevious())->toBeTruthy();

            $pagination = new Pagination(9, 1, 10);
            expect($pagination->hasPrevious())->toBeTruthy();
        });
    });
});
