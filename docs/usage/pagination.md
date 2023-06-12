# Pagination

Version `1.1.x` of the library brought in the `RespositoryBase::fetchPaginated()` method. This method is a convenience
method around `RepositoryBase::fetch()`. It returns an instance of `PaginatedResult`.

```php
$args = [
    'per_page' => 5,
];
$paginatedResult = $registry->posts()->fetchPaginated($args);
$totalItems = $paginatedResult->getPagination()->getTotalItems();
$postEntitiesArray = $paginatedResult->getItems();
```

## PaginatedResult::getItems()

This method returns the array of entities fetched. The array is essentially the same result of
calling `RespositoryBase::fetch()`.

## PaginatedResult::getPagination()

This method returns an instance of `Pagination`, an object containing pagination related information.

## Pagination::getPage()

This method returns the current page fetched.

## Pagination::getLimit()

This method returns the limit ( `per_page` ) value fetched.

## Pagination::getTotalItems()

This method returns the total items found matching the search params.

## Pagination::getTotalPages()

This method returns the total pages based on the total items and the limit.

## Pagination::hasNext()

This method returns a boolean indicating if there is a page after the current `page` value.

## Pagination::hasPrevious()

This method returns a boolean indicating if there is a page before the current `page` value.

## Pagination::nextPage()

This method returns the next page or the max total pages (whichever is lower ).

## Pagination::previousPage()

This method returns the previous page or 1 (whichever is higher ).