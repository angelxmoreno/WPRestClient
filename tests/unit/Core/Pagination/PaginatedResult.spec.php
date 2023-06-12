<?php

declare(strict_types=1);

use WPRestClient\Core\Pagination\PaginatedResult;
use WPRestClient\Core\Pagination\Pagination;

describe(PaginatedResult::class, function () {
    given('items', fn() => [1, 2, 3]);
    given('page', fn() => 2);
    given('limit', fn() => 1);
    given('totalItems', fn() => 6);
    given('paginatedResult', fn() => new PaginatedResult(
        $this->items,
        $this->page,
        $this->limit,
        $this->totalItems
    ));

    describe('->getItems()', function () {
        it('returns the items', function () {
            expect($this->paginatedResult->getItems())->toBe($this->items);
        });
    });

    describe('->getPagination()', function () {
        it('returns an instance of ' . Pagination::class, function () {
            $pagination = $this->paginatedResult->getPagination();
            expect($pagination)->toBeAnInstanceOf(Pagination::class);
            expect($pagination->getPage())->toBe($this->page);
            expect($pagination->getLimit())->toBe($this->limit);
            expect($pagination->getTotalItems())->toBe($this->totalItems);
        });
    });
});
