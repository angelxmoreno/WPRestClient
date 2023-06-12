# Repositories

**Repositories Classes** are classes that return entity objects for their correlating content type. For
example, `PostsRepositories` return `PostEntity` objects.

## RepositoryRegistry

All repositories require an instance of `ApiClient`:

```php
use WPRestClient\Core\ApiClient;
use WPRestClient\Repository\PostsRepository;
use WPRestClient\Repository\PagesRepository;

$apiClient = new ApiClient('https://wp-example.com');
PostsRepository::setApiClient($apiClient);
$post = PostsRepository::get(123);
```

The easiest way to load the `ApiClient` into all the repositories is via the `RepositoryRegistry`:

```php
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\RepositoryRegistry;

$apiClient = new ApiClient('https://wp-example.com');
$registry = new RepositoryRegistry($apiClient);
$post = $registry->posts()->get(123);
```

## List of repositories

| Method                    | Repository             |
|---------------------------|------------------------|
| `$registry->categories()` | `CategoriesRepository` |
| `$registry->comments()`   | `CommentsRepository`   |
| `$registry->medias()`     | `MediasRepository`     |
| `$registry->pages()`      | `PagesRepository`      |
| `$registry->posts()`      | `PostsRepository`      |
| `$registry->tags()`       | `TagsRepository`       |
| `$registry->users()`      | `UsersRepository`      |

!!! note

    Learn how to create [your own repositories](../extending/repository.md).

## Repository::get()

The `get()` method fetches a single content type by its id.

```php
$postEntity = $registry->posts()->get(1);
$postEntity->getId(); // returns 1
```

## Repository::fetch()

The `fetch()` method fetches multiple content types based on search arguments.

```php
$args = [
    'per_page' => 5,
];
$postEntitiesArray = $registry->posts()->fetch($args);
```

!!! note

    Learn what arguments are available to you for each respository by visiting the [WordPress Rest API Reference](https://developer.wordpress.org/rest-api/reference/).

## Repository::fetchPaginated()

The `fetchPaginated()` method is a wrapper for the `fetch` method. It takes the same parameters as the `fetch()` method
and returns a `PaginatedResult` object.

```php
$args = [
    'per_page' => 5,
];
$paginatedResult = $registry->posts()->fetchPaginated($args);
$totalItems = $paginatedResult->getPagination()->getTotalItems();
$postEntitiesArray = $paginatedResult->getItems();
```

!!! note

    Learn more about [Pagination objects](pagination.md)

## Repository::save()

The `save()` method takes an entity and either creates or updates content. If the entity has an `id` the repository
assumes the content already exists and will do an update. When the `id` of an entity is null, it will create the
content.

```php
# create a new Page
$entity = new PageEntity([
    'title' => 'About Page',
    'content' => 'This is the about page'
]);
$entity = $registry->pages()->save($entity);

# update the title of an existing category
$entity = $registry->categories()->get(1);
$entity->setName('A new Name)
$entity = $registry->pages()->save($entity);
```

!!! note

    Learn what arguments are available to you for each respository by visiting the [WordPress Rest API Reference](https://developer.wordpress.org/rest-api/reference/).

## Repository::delete()

The `delete()` method takes an entity and deletes the content remotely.

```php
$entity = $registry->tags()->get(1);
$registry->tags()->delete($entity);
```

## Repository::delete()

The `delete()` method takes an entity and deletes the content remotely.

```php
$entity = $registry->tags()->get(1);
$registry->tags()->delete($entity);
```
