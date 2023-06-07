<?php

declare(strict_types=1);

namespace WPRestClient\Repository;

use WPRestClient\Core\Repository\RepositoryBase;
use WPRestClient\Entity\CategoryEntity;

class CategoriesRepository extends RepositoryBase
{
    protected static ?string $path = 'categories';
    protected static ?string $entityClass = CategoryEntity::class;
}
