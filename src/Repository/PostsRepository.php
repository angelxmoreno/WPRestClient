<?php

declare(strict_types=1);

namespace WPRestClient\Repository;

use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\PostEntity;

class PostsRepository extends RepositoryBase
{
    protected static ?string $path = 'posts';
    protected static ?string $entityClass = PostEntity::class;
}
