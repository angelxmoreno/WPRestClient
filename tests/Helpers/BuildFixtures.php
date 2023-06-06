<?php

declare(strict_types=1);

namespace WPRestClient\Test\Helpers;

use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use GuzzleHttp\Exception\GuzzleException;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\RepositoryRegistry;

class BuildFixtures
{
    protected ApiClient $apiClient;
    protected RepositoryRegistry $registry;

    /**
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        $this->registry = new RepositoryRegistry($apiClient);
    }

    /**
     * @throws GuzzleException
     */
    public function buildFixtures(): void
    {
        $aliases = $this->registry->getAliases();
        foreach ($aliases as $alias) {
            $repository = $this->registry->getRepository($alias);
            $uri = $repository::getPath();
            $collection = $this->apiClient->sendRequest('get', $uri);
            Fixture::generate($uri, $collection);

            $firstId = Hash::get($collection, '0.id');

            $single = $this->apiClient->sendRequest('get', $uri . '/' . $firstId);
            Fixture::generate(Inflector::singularize($uri), $single);
        }
    }
}
