<?php

declare(strict_types=1);

namespace WPRestClient\Core;

use RuntimeException;
use UnexpectedValueException;
use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Repository\PostsRepository;

class RepositoryRegistry
{
    protected ApiClient $apiClient;

    /**
     * @var RepositoryBase[]
     */
    protected array $repositories = [
        'posts' => PostsRepository::class,
    ];

    /**
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function addRepository(string $className, string $alias): void
    {
        if (!class_exists($className)) {
            throw new UnexpectedValueException(sprintf(
                '%s can not be found',
                $className
            ));
        }

        if (!is_subclass_of($className, RepositoryBase::class)) {
            throw new UnexpectedValueException(sprintf(
                '%s is not a child class of %s',
                $className,
                RepositoryBase::class
            ));
        }

        $this->repositories[strtolower($alias)] = $className;
    }

    public function __call($methodName, $args)
    {
        if (empty($args) && isset($this->repositories[$methodName])) {
            return $this->getRepository($methodName);
        }

        throw new RuntimeException(sprintf('method "%s" does not exist in class "%s"', $methodName, get_class($this)));
    }

    /**
     * @param string $alias
     * @return string|RepositoryBase
     */
    public function getRepository(string $alias): string
    {
        if (!isset($this->repositories[$alias])) {
            throw new RuntimeException(sprintf('%s is not a valid repository alias', $alias));
        }

        $repository = $this->repositories[$alias];
        $repository::setApiClient($this->apiClient);
        return $repository;
    }

    public function getAliases(): array
    {
        return array_keys($this->repositories);
    }
}
