<?php

declare(strict_types=1);

namespace WPRestClient\Repository;

use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\PostEntity;

class UsersRepository extends RepositoryBase
{
    protected static ?string $path = 'users';
}
