<?php

declare(strict_types=1);

namespace WPRestClient\Core\Repository;

use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use GuzzleHttp\Exception\GuzzleException;
use WPRestClient\Core\ApiClient;
use WPRestClient\Core\ApiResponseException;
use WPRestClient\Core\Entity\EntityBase;
use WPRestClient\Core\MemoizedTrait;
use WPRestClient\Core\Pagination\PaginatedResult;
use WPRestClient\Util\ArrayDiffRecursive;

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
     * @throws GuzzleException|ApiResponseException
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
     * @throws GuzzleException|ApiResponseException
     */
    public static function fetchPaginated(array $params = []): PaginatedResult
    {
        $params = array_merge([
            'per_page' => 20,
            'page' => 1,
        ], $params);
        $response = self::getApiClient()->sendRequest('get', self::getPath(), $params);
        static::addBatchMemoize($response['data']);

        $entityClass = static::getEntityClass();
        $entities = [];
        foreach ($response['data'] as $datum) {
            $entities[] = new $entityClass($datum);
        }

        $page = Hash::get($params, 'page');
        $limit = Hash::get($params, 'per_page');
        $totalItems = Hash::get($response['headers'], 'X-WP-Total', 1);
        return new PaginatedResult($entities, $page, $limit, $totalItems);
    }


    /**
     * @throws GuzzleException|ApiResponseException
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

    /**
     * @throws GuzzleException|ApiResponseException
     */
    public static function save(EntityBase $entity): EntityBase
    {
        return is_null($entity->getId())
            ? self::create($entity->jsonSerialize())
            : self::update($entity);
    }

    /**
     * @throws GuzzleException|ApiResponseException
     */
    protected static function create(array $params = []): EntityBase
    {
        $response = self::getApiClient()->sendRequest('post', self::getPath(), $params);
        $data = $response['data'] ?? null;
        if (!is_null($data)) {
            static::addMemoize($data);
        }

        $entityClass = static::getEntityClass();
        return new $entityClass($data);
    }

    /**
     * @throws GuzzleException|ApiResponseException
     */
    protected static function update(EntityBase $entity): ?EntityBase
    {
        $original = self::get($entity->getId());
        $diff = ArrayDiffRecursive::diff($entity->jsonSerialize(), $original->jsonSerialize());
        $response = self::getApiClient()->sendRequest('put', self::getPath() . '/' . $entity->getId(), $diff);
        $data = $response['data'] ?? null;
        if (!is_null($data)) {
            static::addMemoize($data);
        }

        $entityClass = static::getEntityClass();
        return new $entityClass($data);
    }

    /**
     * @throws GuzzleException|ApiResponseException
     */
    public static function delete(EntityBase $entity): array
    {
        $response = self::getApiClient()->sendRequest('delete', self::getPath() . '/' . $entity->getId());
        static::removeMemoize($entity->getId());
        $data = $response['data'] ?? null;
        $entityClass = static::getEntityClass();

        return (new $entityClass($data))->jsonSerialize();
    }
}
