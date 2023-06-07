<?php

declare(strict_types=1);

namespace WPRestClient\Repository;

use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\CommentEntity;
use WPRestClient\Entity\PostEntity;
use WPRestClient\Entity\TagEntity;

class TagsRepository extends RepositoryBase
{
    protected static ?string $path = 'tags';
    protected static ?string $entityClass = TagEntity::class;
}
