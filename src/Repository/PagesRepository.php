<?php

declare(strict_types=1);

namespace WPRestClient\Repository;

use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\CommentEntity;
use WPRestClient\Entity\PageEntity;
use WPRestClient\Entity\PostEntity;

class PagesRepository extends RepositoryBase
{
    protected static ?string $path = 'pages';
    protected static ?string $entityClass = PageEntity::class;
}
