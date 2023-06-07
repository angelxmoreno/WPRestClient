<?php

declare(strict_types=1);

namespace WPRestClient\Repository;

use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\UserEntity;

class UsersRepository extends RepositoryBase
{
    protected static ?string $path = 'users';
    protected static ?string $entityClass = UserEntity::class;
}
