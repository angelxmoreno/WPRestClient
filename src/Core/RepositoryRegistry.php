<?php

declare(strict_types=1);

namespace WPRestClient\Core;

use RuntimeException;
use UnexpectedValueException;
use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Repository;

/**
 * RepositoryRegistry class for managing and retrieving repository instances.
 *
 * Provides methods to dynamically retrieve repository instances using magic methods.
 *
 * @method Repository\CategoriesRepository categories()
 * @method Repository\CommentsRepository comments()
 * @method Repository\MediasRepository medias()
 * @method Repository\PagesRepository pages()
 * @method Repository\PostsRepository posts()
 * @method Repository\TagsRepository tags()
 * @method Repository\UsersRepository users()
 */
class RepositoryRegistry
{
    protected ApiClient $apiClient;

    /**
     * @var RepositoryBase[]
     */
    protected array $repositories = [
        'categories' => Repository\CategoriesRepository::class,
        'comments' => Repository\CommentsRepository::class,
        'medias' => Repository\MediasRepository::class,
        'pages' => Repository\PagesRepository::class,
        'posts' => Repository\PostsRepository::class,
        'tags' => Repository\TagsRepository::class,
        'users' => Repository\UsersRepository::class,
    ];

    /**
     * Constructor method.
     *
     * @param ApiClient $apiClient The API client instance.
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Add a new repository to the registry.
     *
     * @param string $className The class name of the repository.
     * @param string $alias The alias for the repository.
     * @return void
     * @throws UnexpectedValueException If the class does not exist or is not a subclass of RepositoryBase.
     */
    public function addRepository(string $className, string $alias): void
    {
        if (!class_exists($className)) {
            throw new UnexpectedValueException(sprintf(
                '%s cannot be found',
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

    /**
     * Handle dynamic method calls to get repositories by alias.
     *
     * @param string $methodName The name of the method being called.
     * @param array $args The arguments passed to the method.
     * @return RepositoryBase|string The repository class or instance.
     * @throws RuntimeException If the method does not exist or if arguments are provided.
     */
    public function __call($methodName, $args)
    {
        if (empty($args) && isset($this->repositories[$methodName])) {
            return $this->getRepository($methodName);
        }

        throw new RuntimeException(sprintf('method "%s" does not exist in class "%s"', $methodName, get_class($this)));
    }

    /**
     * Get a repository by alias.
     *
     * @param string $alias The alias of the repository.
     * @return string|RepositoryBase The repository class or instance.
     * @throws RuntimeException If the alias is not valid.
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

    /**
     * Get all repository aliases.
     *
     * @return array An array of repository aliases.
     */
    public function getAliases(): array
    {
        return array_keys($this->repositories);
    }
}
