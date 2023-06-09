<?php

declare(strict_types=1);

namespace WPRestClient\Core\Repository;

use WPRestClient\Core\ApiClient;
use WPRestClient\Core\Entity\EntityBase;

interface RepositoryInterface
{
    public static function getPath(): string;

    public static function getEntityClass(): string;

    public static function getApiClient(): ApiClient;

    public static function setApiClient(ApiClient $apiClient): void;

    public static function get(int $id, array $params = []): EntityBase;

    /**
     * @param array $params
     * @return EntityBase[]
     */
    public static function fetch(array $params = []): array;

    public static function save(EntityBase $entity): EntityBase;

    public static function delete(EntityBase $entity): ?array;
}
