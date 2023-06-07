<?php

declare(strict_types=1);

namespace WPRestClient\Core\Repository;

use Cake\Utility\Inflector;
use GuzzleHttp\Exception\GuzzleException;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\Entity\EntityBase;

abstract class RepositoryBase implements RepositoryInterface
{
    protected static ApiClient $apiClient;
    protected static ?string $path = null;
    protected static ?string $entityClass = null;

    public static function getPath(): string
    {
        if (!static::$path) {
            $parts = explode('\\', static::class);
            $shortName = end($parts);
            $name = str_replace('Repository', '', $shortName);
            $path = strtolower($name);
            self::$path = $path;
        }

        return static::$path;
    }

    public static function getEntityClass(): string
    {
        if (!static::$entityClass) {
            $parts = explode('\\', static::class);
            $shortName = end($parts);
            $name = Inflector::singularize(str_replace('Repository', '', $shortName)) . 'Entity';

            $entityClass = 'WPRestClient\\Entity\\' . $name;

            self::$entityClass = $entityClass;
        }

        if (!class_exists(static::$entityClass)) {
            self::$entityClass = EntityBase::class;
        }

        return static::$entityClass;
    }

    public static function getApiClient(): ApiClient
    {
        return static::$apiClient;
    }

    public static function setApiClient(ApiClient $apiClient): void
    {
        static::$apiClient = $apiClient;
    }

    /**
     * @throws GuzzleException
     */
    public static function fetch(array $params = []): array
    {
        $response = self::getApiClient()->sendRequest('get', self::getPath(), $params);
        $entityClass = static::getEntityClass();
        $entities = [];
        foreach ($response['data'] as $datum) {
            $entities[] = new $entityClass($datum);
        }
        return $entities;
    }

    /**
     * @throws GuzzleException
     */
    public static function get(int $id, array $params = []): EntityBase
    {
        $response = self::getApiClient()->sendRequest('get', self::getPath() . '/' . $id, $params);
        $entityClass = static::getEntityClass();
        return new $entityClass($response['data']);
    }
}
