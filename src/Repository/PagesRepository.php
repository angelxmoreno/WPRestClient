<?php

declare(strict_types=1);

namespace WPRestClient\Repository;

use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\PostEntity;

class PagesRepository extends RepositoryBase
{
    protected static ?string $path = 'pages';
}
