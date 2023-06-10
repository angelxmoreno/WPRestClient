<?php

declare(strict_types=1);

namespace WPRestClient\Core;

use GuzzleHttp\Client;
use WPRestClient\Auth\BasicAuth;

class RegistryFactory
{
    public static function basicAuthConnection(string $domain, string $username, string $password): RepositoryRegistry
    {
        $httpClient = new Client();
        $auth = new BasicAuth($username, $password);
        $apiClient = new ApiClient($domain, $httpClient, $auth);
        return new RepositoryRegistry($apiClient);
    }
}
