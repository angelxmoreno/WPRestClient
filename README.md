# WPRestClient
## Currently under development

WPRestClient is a PHP library for seamless interaction with WordPress sites via the WordPress RESTful API, simplifying 
authentication, data retrieval, and content management tasks

## Features

- Connect to WordPress sites and authenticate using REST API authentication methods.
- Retrieve posts, pages, custom post types, categories, tags, and other WordPress entities.
- Create, update, and delete posts and pages.
- Upload media files to WordPress media library.
- Perform advanced queries and filter responses using the power of the WordPress RESTful API.

## Requirements
PHP 7.4+

## Installation

You can install WPRestClient via Composer. Run the following command in your project directory:

```bash
composer require angelxmoreno/wprestclient
```

## Usage

1. Create a new instance of the WPRestClient:

```php
$client = new WPRestClient('https://example.com', 'YOUR_USERNAME', 'YOUR_PASSWORD');
```

<li>Retrieve a list of posts:</li>

```php
$posts = $client->getPosts();
foreach ($posts as $post) {
    echo $post['title']['rendered'];
}
```

<li>Create a new post:</li>
```php
$data = [
    'title' => 'Hello World',
    'content' => 'This is my first post created with WPRestClient!',
];
$newPost = $client->createPost($data);
```

For more detailed usage examples and available methods, please refer to the 
<a href="https://wordpressapi.readthedocs.io/en/latest/" target="_new">documentation</a>.

## Contribution
Contributions are welcome! If you find a bug, have suggestions for improvements, or would like to add new features,
please submit an issue or a pull request. Make sure to follow our [contribution guidelines](CONTRIBUTION_GUIDELINES)

## License
WPRestClient is open-source software licensed under the [MIT license](LICENSE)

## Contact
For any questions or inquiries, please contact [WPRestClient@gmail.com](mailto:WPRestClient@gmail.com)

## Support
For bugs and feature requests, please use the [issues](https://github.com/angelxmoreno/WPRestClient/issues) section of
this repository.

