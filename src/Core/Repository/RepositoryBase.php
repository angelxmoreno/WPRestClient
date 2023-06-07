<?php

declare(strict_types=1);

namespace WPRestClient\Core\Repository;

use Cake\Utility\Inflector;
use GuzzleHttp\Exception\GuzzleException;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\Entity\EntityBase;
use WPRestClient\Core\MemoizedTrait;

abstract class RepositoryBase implements RepositoryInterface
{
    use MemoizedTrait;

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
        static::addBatchMemoize($response['data']);

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
        $result = static::getMemoize($id);
        if (is_null($result)) {
            $response = self::getApiClient()->sendRequest('get', self::getPath() . '/' . $id, $params);
            $result = $response['data'];
            static::addMemoize($result);
        }

        $entityClass = static::getEntityClass();
        return new $entityClass($result);
    }
}
