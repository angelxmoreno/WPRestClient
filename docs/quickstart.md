# Quickstart

To get started you will need

1. WordPress site
2. A username and
   an [application password](misc/application-password.md)

For the rest of this guide we will be using the following credentials:

| Name                 | Value                   |
|----------------------|-------------------------|
| URL                  | https://wp-example.com/ |
| username             | demouser                |
| application password | demopwd                 |

## Create an instance of the `RepositoryRegistry`

```php
use WPRestClient\Core\RegistryFactory;

$registry = RegistryFactory::basicAuthConnection(
    'https://wp-example.com',
    'demouser',
    'demopwd'
);
```

The above factory simplifies the following orchestration:

```php
use GuzzleHttp\Client;
use WPRestClient\Auth\BasicAuth;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\RepositoryRegistry;

# create an instance of our http client
$httpClient = new Client();

# create an instance of our authenticator
$auth = new BasicAuth('demouser', 'demopwd');

# with our http client and authenticator create an instance of our api client
$apiClient = new ApiClient('https://wp-example.com', $httpClient, $auth);

# with our api client, client an instance of our registry 
$registry = new RepositoryRegistry($apiClient);
```

## Fetch posts

```php
# fetch the last 10 published posts
$registry->posts()->fetch([
    'per_page' => 10,
    'page' => 1,
    'order' => 'desc',
    'orderby' => 'date',
    'status' => 'publish'
]);
```

!!! note

    For more information on the arguments passed to the `fetch()` method for `posts`
    see [rest-api/reference/posts](https://developer.wordpress.org/rest-api/reference/posts/#arguments).
