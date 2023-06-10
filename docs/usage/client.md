# ApiClient

The **ApiClient** class serves as a way to communicate with the WordPress Rest API.

## GuzzleHttp\Client

The `ApiClass` takes an optional instance of `GuzzleHttp\Client`. If one is not passed the class wil create one. This
allows the `ApiClient` class to inherent customization and flexibility. For example, out of box the library does not
offer logging. However, a
logging [middleware](https://docs.guzzlephp.org/en/stable/handlers-and-middleware.html#middleware) could easily be added
to the `GuzzleHttp\Client`.

## AuthInterface

The Auth instances are objects that augment the PSR-7 Request objects to allow access to the WordPress Rest API. An
optional `AuthInterface` object can be passed to the `ApiClass` via its constructor or via the `->setAuth()` method:

```php
use WPRestClient\Core\ApiClient;

# via constructor
$apiClient = new ApiClient('https://wp-example.com', null, $auth);

# via the auth setter
$apiClient->setAuth($auth);
```

Currently, the library comes with a `BasicAuth` class that
uses [username and application password](https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/#basic-authentication-with-application-passwords).
You can [create your own Authentication class](../extending/authentication.md) to fit your needs. You are invited to
submit a PR with your custom Auth class while following our [Contribution Guidelines](../contributing.md).
!!! note

    Learn more about WordPress Rest API Authentication by visiting the [WordPress Rest API Reference](https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/).

## Api Prefix

Out of box, the `ApiClient` uses the default api prefix `/wp-json/wp/v2/`. There are plugins that allow you to change
this value and thus, the value can be changed via the `setApiPrefix()` method:

```php
use WPRestClient\Core\ApiClient;

$apiClient = new ApiClient('https://wp-example.com');
$apiClient->setApiPrefix('/rest/');
```

## Sending Requests

To send requests via the `ApiClient`, simply provide an HTTP method, the uri and optional parameters to
the `sendRequest()` method. The method returns an array containing two keys, `data` and `headers`. Below are some
examples:

```php

# fetch a list of users
$usersResponse = $apiClient->sendRequest('get', '/users');
$users = $usersResponse['data'];

# fetch a list of categories for a specific post
$categoriesResponse = $apiClient->sendRequest('get', '/categories', [ 'post' => 123 ]);
$categories = $categoriesResponse['data'];
$total = $categoriesResponse['headers']['X-WP-Total']

# create a new page called `Hobbies`
$apiClient->sendRequest('post', '/pages', [ 'title' => 'Hobbies' ]);

# change the title of an existing post
$apiClient->sendRequest('put', '/posts', [ 'id' => 123, 'title' => 'A new Title' ]);

# delete an existing tag
$apiClient->sendRequest('delete', '/tag', [ 'id' => 456 ]);

```