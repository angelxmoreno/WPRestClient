<?php

declare(strict_types=1);

namespace WPRestClient\Repository;

use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\CommentEntity;
use WPRestClient\Entity\MediaEntity;
use WPRestClient\Entity\PostEntity;

class MediasRepository extends RepositoryBase
{
    protected static ?string $path = 'media';
    protected static ?string $entityClass = MediaEntity::class;
}
